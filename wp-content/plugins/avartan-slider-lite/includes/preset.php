<?php

if (!defined('ABSPATH'))
    exit();

class avsLitePreset {

    private $id;
    private $title;
    private $image;
    private $totalslide;
    private $params;
    private $layers;
    private $visibility;
    public static $core_obj;

    function __construct() {
        self::$core_obj = new AvartanSliderLiteCore();
    }

    /**
     * Get id of preset
     *
     * @since 1.4
     */
    function getId() {
        return $this->id;
    }

    /**
     * Get title of preset
     *
     * @since 1.4
     */
    function getTitle() {
        return $this->title;
    }

    /**
     * Get image of preset
     *
     * @since 1.4
     */
    function getImage() {
        return $this->image;
    }

    /**
     * Get parameters of preset
     *
     * @since 1.4
     */
    function getParams() {
        return $this->params;
    }

    /**
     * Get layers of preset
     *
     * @since 1.4
     */
    function getLayers() {
        return $this->layers;
    }

    /**
     * Get visibility of preset
     *
     * @since 1.4
     */
    function getVisibility() {
        return $this->visibility;
    }

    /**
     * Get total slide of preset
     *
     * @since 1.4
     */
    function getTotalSlides() {
        return $this->totalslide;
    }

    /**
     * Initialize single preset for data
     *
     * @since 1.4
     * @param array $arrData
     */
    public function initSinglePreset($arrData) {
        $this->id = $arrData->id;
        $this->title = $arrData->title;
        $this->image = $arrData->image;
        $this->params = $arrData->params;
        $this->layers = $arrData->layers;
        $this->visibility = isset($arrData->visibility) ? $arrData->visibility : '1';
    }

    /**
     * Initialize single preset by id
     *
     * @since 1.4
     * @param integer $id
     */
    public function initSinglePresetById($id = '') {
        $select = '*';
        $from = avsLiteGlobals::$avs_preset_tbl;
        $where = 'id =' . $id;
        try {
            $response = self::$core_obj->fetch($select, $from, $where);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            exit;
        }
        return $this->initSinglePreset($response[0]);
    }

    /**
     * Get all preset
     *
     * @since 1.4
     */
    public function getAllPreset() {
        $select = '*';
        $from = avsLiteGlobals::$avs_preset_tbl;
        $where = 'type="standard-slider"';
        $order_by = '';
        $group_by = 'id';
        $response = self::$core_obj->fetch($select, $from);
        $all_preset = array();
        foreach ($response as $sArr) {
            $preset = $this->initSinglePreset($sArr);
            $all_preset[] = array(
                'id' => $this->id,
                'title' => $this->title,
                'image' => $this->image,
                'params' => $this->params,
                'layers' => $this->layers,
                'visibility' => $this->visibility
            );
        }
        return $all_preset;
    }

}