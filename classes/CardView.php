<?php
include_once "View.php";
class CardView extends View {
    private $title;
    private $cards;
    private $marker;

    public function __construct() {
        parent::__construct('templates/card.html');
        $this->cards = "";
    }

    public function set_marker($marker) {
        $this->marker = $marker;
    }

    public function get_marker() {
        return $this->marker;
    }

    public function set_title($title) {
        $this->title = $title;
    }

    public function set_cards($datas, $placeholders) {
        $template = '<div class="col gx-2 gy-3 justify-content-center">
            <a href="__DETAIL_URL__">
                <div class="card pt-4 px-2 pengurus-thumbnail">
                    <div class="row justify-content-center">
                        <img src="../assets/images/__IMAGENAME__" class="card-img-top" alt="__IMAGENAME__">
                    </div>
                    <div class="card-body">
                        <p class="card-text pengurus-nama my-0">__DATA0__</p>
                        <p class="card-text divisi-nama">__DATA1__</p>
                        <p class="card-text jabatan-nama my-0">__DATA2__</p>
                    </div>
                </div>
            </a>
        </div>';
    
        foreach($datas as $data) {
            $temp = $template;
            foreach ($placeholders as $placeholder => $key) {
                $temp = preg_replace("/$placeholder/", $data[$key], $temp);
            }
            $this->cards .= $temp;
        }
    }
    

    public function insert_content($content){
        $this->set_title($content["title"]);
        $this->replace('__TITLE__', $this->title);
        $this->set_cards($content["datas"], $content["placeholders"]);
        $this->replace('__CARDS__', $this->cards);
    }

    public function get_view() {
        return $this->getContent();
    }

    public function show() {
        $this->write();
    }
}