<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

App::uses('FormAuthenticate', 'Controller/Component/Auth');
use \COM;
use \Exception;

class BcryptFormAuthenticate extends FormAuthenticate {
 
    /**
     * The default log2 number of iterations for Blowfish encryption.
     */
    const BF = 10;

    /**
     * The default log2 number of iterations for XDES encryption.
     */
    const XDES = 18;

    /**
     * Option flag used in `String::random()`.
     */
    const ENCODE_BASE_64 = 1;

    /**
     * A closure which, given a number of bytes, returns that amount of
     * random bytes.
     *
     * @var Closure
     */
    protected static $_source;

/**
 * Find a user record using the standard options.
 *
 * Checks the password using the hash function
 * This allows for indivdual salts to be used for each password
 * 
 * @param string $username The username/identifier.
 * @param string $password The unhashed password.
 * @return Mixed Either false on failure, or an array of user data.
 */
    protected function _findUser($username, $password = null) {
        $userModel = $this->settings['userModel'];
		$userModel = 'AdminUser.AdminUser';
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->settings['fields'];

        $conditions = array(
            $model . '.' . $fields['username'] => $username
        );
        if (!empty($this->settings['scope'])) {
            $conditions = array_merge($conditions, $this->settings['scope']);
        }
       // $result = ClassRegistry::init($userModel)->find('first', array(
	   $result = ClassRegistry::init($model)->find('first', array(
            'conditions' => $conditions,
            'recursive' => $this->settings['recursive']
        ));
        if (empty($result) || empty($result[$model])) {
            return false;
        }

        // If the user's password hash doesn't match the results, return false
        if (!static::check($password, $result[$model][$fields['password']])) {
            return false;
        }

        unset($result[$model][$fields['password']]);
        return $result[$model];
    }

    /**
     * Create a blowfish / bcrypt hash.
     * Individual salts are used to be even more secure.
     *
     * @param string $password Password.
     * @return string Hashed password.
     */
    public static function hash($password, $salt = null) {
        return crypt($password, $salt ?: static::salt());
    }
    
    /**
     * Compares a password and its hashed value using PHP's `crypt()`. Rather than a simple string
     * comparison, this method uses a constant-time algorithm to defend against timing attacks.
     *
     * @see lithium\security\Password::hash()
     * @see lithium\security\Password::salt()
     * @param string $password The password to check.
     * @param string $hash The hashed password to compare it to.
     * @return boolean Returns a boolean indicating whether the password is correct.
     */
    public static function check($password, $hash) {
        return static::compare(crypt($password, $hash), $hash);
    }

    /**
     * Compares two strings in constant time to prevent timing attacks.
     *
     * @link http://codahale.com/a-lesson-in-timing-attacks/ More about timing attacks.
     * @param string $left The left side of the comparison.
     * @param string $right The right side of the comparison.
     * @return boolean Returns a boolean indicating whether the two strings are equal.
     */
    public static function compare($left, $right) {
        $result = true;

        if (($length = strlen($left)) != strlen($right)) {
            return false;
        }
        for ($i = 0; $i < $length; $i++) {
            $result = $result && ($left[$i] === $right[$i]);
        }
        return $result;
    }


    /**
     * Generates a cryptographically strong salt, using the best available
     * method (tries Blowfish, then XDES, and fallbacks to MD5), for use in
     * `Password::hash()`.
     *
     * Blowfish and XDES are adaptive hashing algorithms. MD5 is not. Adaptive
     * hashing algorithms are designed in such a way that when computers get
     * faster, you can tune the algorithm to be slower by increasing the number
     * of hash iterations, without introducing incompatibility with existing
     * passwords.
     *
     * To pick an appropriate iteration count for adaptive algorithms, consider
     * that the original DES crypt was designed to have the speed of 4 hashes
     * per second on the hardware of that time. Slower than 4 hashes per second
     * would probably dampen usability. Faster than 100 hashes per second is
     * probably too fast. The defaults generate about 10 hashes per second
     * using a dual-core 2.2GHz CPU.
     *
     *  _Note 1_: this salt generator is different from naive salt implementations
     * (e.g. `md5(microtime())`) in that it uses all of the available bits of
     * entropy for the supplied salt method.
     *
     *  _Note2_: this method should not be use to generate custom salts. Indeed,
     * the resulting salts are prefixed with information expected by PHP's
     * `crypt()`. To get an arbitrarily long, cryptographically strong salt
     * consisting in random sequences of alpha numeric characters, use
     * `lithium\util\String::random()` instead.
     *
     * @link http://php.net/manual/en/function.crypt.php
     * @link http://www.postgresql.org/docs/9.0/static/pgcrypto.html
     * @see lithium\security\Password::hash()
     * @see lithium\security\Password::check()
     * @see lithium\util\String::random()
     * @param string $type The hash type. Optional. Defaults to the best
     *        available option. Supported values, along with their maximum
     *        password lengths, include:
     *        - `'bf'`: Blowfish (128 salt bits, max 72 chars)
     *        - `'xdes'`: XDES (24 salt bits, max 8 chars)
     *        - `'md5'`: MD5 (48 salt bits, unlimited length)
     * @param integer $count Optional. The base-2 logarithm of the iteration
     *        count, for adaptive algorithms. Defaults to:
     *        - `10` for Blowfish
     *        - `18` for XDES
     * @return string The salt string.
     */
    public static function salt($type = null, $count = null) {
        switch (true) {
            case CRYPT_BLOWFISH == 1 && (!$type || $type === 'bf'):
                return static::_genSaltBf($count);
            case CRYPT_EXT_DES == 1 && (!$type || $type === 'xdes'):
                return static::_genSaltXDES($count);
            default:
                return static::_genSaltMD5();
        }
    }

    /**
     * Generates a Blowfish salt for use in `lithium\security\Password::hash()`. _Note_: Does not
     * use the `'encode'` option of `String::random()` because it could result in 2 bits less of
     * entropy depending on the last character.
     *
     * @param integer $count The base-2 logarithm of the iteration count.
     *        Defaults to `10`. Can be `4` to `31`.
     * @return string The Blowfish salt.
     */
    protected static function _genSaltBf($count = null) {
        $count = (integer) $count;
        $count = ($count < 4 || $count > 31) ? static::BF : $count;

        $base64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $i = 0;

        $input = static::random(16);
        $output = '';

        do {
            $c1 = ord($input[$i++]);
            $output .= $base64[$c1 >> 2];
            $c1 = ($c1 & 0x03) << 4;
            if ($i >= 16) {
                $output .= $base64[$c1];
                break;
            }

            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 4;
            $output .= $base64[$c1];
            $c1 = ($c2 & 0x0f) << 2;

            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 6;
            $output .= $base64[$c1];
            $output .= $base64[$c2 & 0x3f];
        } while (1);

        return '$2a$' . chr(ord('0') + $count / static::BF) . chr(ord('0') + $count % static::BF) . '$' . $output;
    }

    /**
     * Generates an Extended DES salt for use in `lithium\security\Password::hash()`.
     *
     * @param integer $count The base-2 logarithm of the iteration count. Defaults to `18`. Can be
     *                `1` to `24`. 1 will be stripped from the non-log value, e.g. 2^18 - 1, to
     *                ensure we don't use a weak DES key.
     * @return string The XDES salt.
     */
    protected static function _genSaltXDES($count = null) {
        $count = (integer) $count;
        $count = ($count < 1 || $count > 24) ? static::XDES : $count;

        $count = (1 << $count) - 1;
        $base64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $output = '_' . $base64[$count & 0x3f] . $base64[($count >> 6) & 0x3f];
        $output .= $base64[($count >> 12) & 0x3f] . $base64[($count >> 18) & 0x3f];
        $output .= static::random(3, array('encode' => static::ENCODE_BASE_64));

        return $output;
    }

    /**
     * Generates an MD5 salt for use in `lithium\security\Password::hash()`.
     *
     * @return string The MD5 salt.
     */
    protected static function _genSaltMD5() {
        return '$1$' . static::random(6, array('encode' => static::ENCODE_BASE_64));
    }


    /**
     * Generates random bytes for use in UUIDs and password salts, using
     * (when available) a cryptographically strong random number generator.
     *
     * {{{
     * $bits = String::random(8); // 64 bits
     * $hex = bin2hex($bits); // [0-9a-f]+
     * }}}
     *
     * Optionally base64-encodes the resulting random string per the following:
     *
     *  _The alphabet used by `base64_encode()` is different than the one we should be using. When
     * considering the meaty part of the resulting string, however, a bijection allows to go the
     * from one to another. Given that we're working on random bytes, we can use safely use
     * `base64_encode()` without losing any entropy._
     *
     * @param integer $bytes The number of random bytes to generate.
     * @param array $options The options used when generating random bytes:
     *              - `'encode'` _integer_: If specified, and set to `String::ENCODE_BASE_64`, the
     *                resulting value will be base64-encoded, per the notes above.
     * @return string Returns a string of random bytes.
     */
    public static function random($bytes, array $options = array()) {
        $defaults = array('encode' => null);
        $options += $defaults;

        $source = static::$_source ?: static::_source();
        $result = $source($bytes);

        if ($options['encode'] != static::ENCODE_BASE_64) {
            return $result;
        }
        return strtr(rtrim(base64_encode($result), '='), '+', '.');
    }

    /**
     * Initializes `String::$_source` using the best available random number generator.
     *
     * When available, `/dev/urandom` and COM gets used on *nix and
     * [Windows systems](http://msdn.microsoft.com/en-us/library/aa388182%28VS.85%29.aspx?ppud=4),
     * respectively.
     *
     * If all else fails, a Mersenne Twister gets used. (Strictly
     * speaking, this fallback is inadequate, but good enough.)
     *
     * @see lithium\util\String::$_source
     * @return closure Returns a closure containing a random number generator.
     */
    protected static function _source() {
        switch (true) {
            case isset(static::$_source):
                return static::$_source;
            case is_readable('/dev/urandom') && $fp = fopen('/dev/urandom', 'rb'):
                return static::$_source = function($bytes) use (&$fp) {
                    return fread($fp, $bytes);
                };
            case class_exists('COM', false):
                try {
                    $com = new COM('CAPICOM.Utilities.1');
                    return static::$_source = function($bytes) use ($com) {
                        return base64_decode($com->GetRandom($bytes, 0));
                    };
                } catch (Exception $e) {
                }
            default:
                return static::$_source = function($bytes) {
                    $rand = '';

                    for ($i = 0; $i < $bytes; $i++) {
                        $rand .= chr(mt_rand(0, 255));
                    }
                    return $rand;
                };
        }
    }
}
 