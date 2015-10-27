<?php
App::uses('HtmlHelper', 'View/Helper');

class BootstrapHtmlHelper extends HtmlHelper {

    public $helpers = array('Html');

    public function breadcrumb($items, $options = array()) {
        $default = array(
            'class' => 'breadcrumb',
        );
        $options += $default;

        $count = count($items);
        $li = array();
        for ($i=0; $i < $count - 1; $i++) {
            $text = $items[$i];
            $text .= '&nbsp;<span class="divider">/</span>';
            $li[] = $this->Html->tag('li', $text);
        }
        $li[] = $this->Html->tag('li', end($items), array('class' => 'active'));
        return $this->Html->tag('ul', implode("\n", $li), $options);
    }

}