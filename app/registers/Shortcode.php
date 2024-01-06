<?php
namespace MFFBox\registers;
use MFFBox\shortcode\Table;
class Shortcode
{   
   protected  Table $table;
    public function __construct(){
        $this->table = new Table();
        $this->table();
    }

    public function table(){
        add_shortcode( 'mffbox-table', array( $this->table, 'init' ) );
    }

}