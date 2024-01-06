<?php
namespace MFFBox\shortcode;

class Table
{   
    public const FILTER_META_ID = "_tribe_tickets_meta";
    public const FILTER_PARAM_GENDER = "sexo";
    public const PARAM_SHORTCODE = "campeonato";
    public const FILTER_ORDER_STATUS = "wc-completed";
    private int $id;
    public function __construct(){

    }    
    /**
     * init
     *
     * @param  mixed $params
     * @return string
     */
    public function init($params){
        $this->id = $params[self::PARAM_SHORTCODE];
        $players = $this->getAllPlayers($this->id);
        $table_data = $this->getDataTable($players);
        return $this->load('table', $table_data);
    }
    /**
     * Get all players, if the o id same post
     *
     * @param  int $id
     * @return array
     */
    private function getAllPlayers(int $id){
        global $wpdb;
        
        $players = $wpdb->get_results(
            $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta 
            INNER JOIN wp_posts ON wp_posts.ID = wp_postmeta.post_id 
            LEFT JOIN wp_wc_orders ON wp_wc_orders.id = wp_posts.ID 
                WHERE meta_key = %s AND 
                (wp_posts.post_status = %s OR wp_wc_orders.status = %s);",
                self::FILTER_META_ID, self::FILTER_ORDER_STATUS, self::FILTER_ORDER_STATUS), 
            ARRAY_N
        );

        $data = $this->unserializeData($players, $id);
        return $data;
    }
    
    /**
     * unserializeData
     *
     * @param  array $data
     * @param  int $id
     * @return array
     */
    private function unserializeData(array $data, $id){
        $data_f = [];
        foreach($data as $key => $value){
            $value = unserialize($value[0]);
            if (isset($value[0]['id']) &&  isset($value[0]['type']) && isset($value[0]['required'])){
                continue;
            }
            if (isset($value[$id])){

                foreach($value[$id] as $v){
                    $data_f[] = $v;
                }
            
            }
           
        }
        return $data_f;
    }    
    /**
     * load
     *
     * @param  mixed $view
     * @param  mixed $params
     * @return string
     */
    protected function load(string $view, $params= []){
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader(__DIR__."/../../view")
        );
       return $twig->render($view.'.twig.php',$params); 

    }    
    /**
     * getDataTable
     *
     * @param  mixed $players
     * @return array
     */
    private function getDataTable($players){

        $column = [];
        $rows_masc = [];
        $rows_fem = [];
        if (count($players) > 0){
            $column = array_keys($players[0]);
        }
        foreach($players as $key => $data){
            if ($data[self::FILTER_PARAM_GENDER] == "Masculino"){
                $rows_masc[] = array_values($data);
            }else{
                $rows_fem[] = array_values($data);
            }
            $rows[] = array_values($data);
        }
        return [
            "table" => array(
                "title" => get_the_title($this->id),
                "columns" => json_encode($column),
                "data" => [
                    "feminino" => json_encode($rows_fem),
                    "masculino" => json_encode($rows_masc),
                ]
            )
        ];
    }
}