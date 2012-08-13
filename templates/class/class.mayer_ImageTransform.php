<?php

class mayer_ImageTransform {

    private $settings;
    private $mainImage;
    public $ignoreMainImage = false;
    private $images;
    private $default = array('width' => 100, 'height' => 100);
    private $globals;

    function __construct() {
		$this->setGlobals();

		if (!class_exists("nc_ImageTransform")) {
			global $nc_core;
			require_once($nc_core->INCLUDE_FOLDER . "classes/nc_imagetransform.class.php");
		}

		$this->loadSettings();
    }

    public function add($name, $crop = 0, $width = 0, $height = 0) {

		if ($width == 0 && isset($this->settings[$name . '_width'])) {
			$width = $this->settings[$name . '_width'];
		} else if ($width == 0) {
			$width = $this->default['width'];
		}

		if ($height == 0 && isset($this->settings[$name . '_height'])) {
			$height = $this->settings[$name . '_height'];
		} else if ($height == 0) {
			$height = $this->default['height'];
		}

		$this->images[$name] = array(
			'name' => $name,
			'width' => $width,
			'height' => $height,
			'crop' => $crop
		);
    }

    public function start() {
		if (empty($this->mainImage)) {
			return;
		}

		$photo_path = $this->getFilePath($this->mainImage['name']);
		if ($this->checkExist($this->mainImage['name'])) {
			if (count($this->images) > 0) {
				foreach ($this->images as $image) {
					$this->createThumb($this->mainImage['name'], $image['name'], $image['width'], $image['height'], $image['crop']);
				}
			}
			if (!$this->ignoreMainImage) {
				$this->resize($photo_path, $this->mainImage['width'], $this->mainImage['height'], $this->mainImage['crop']);
			}
		}
    }

    public function resize($photo_path, $width, $height, $crop = 0) {
		list($original_width, $original_height, $type, $attr) = getimagesize($photo_path);
		
		if($width < $original_width && $height < $original_height) {
			nc_ImageTransform::imgResize($photo_path, $photo_path, $width, $height, $crop);	
		} else if($width > $original_width && $height < $original_height) {
			nc_ImageTransform::imgResize($photo_path, $photo_path, $original_width, $height, $crop);					
		} else if($width < $original_width && $height > $original_height) {
			nc_ImageTransform::imgResize($photo_path, $photo_path, $width, $original_height, $crop);			
		}
    }

    public function createThumb($normal_image, $preview_image, $width, $height, $crop = 0) {
		nc_ImageTransform::createThumb($normal_image, $preview_image, $width, $height, $crop);
    }

    public function addMainImage($name, $crop = 0, $width = 0, $height = 0) {
		if ($width == 0 && isset($this->settings[$name . '_width'])) {
			$width = $this->settings[$name . '_width'];
		} else if ($width == 0) {
			$width = $this->default['width'];
		}

		if ($height == 0 && isset($this->settings[$name . '_height'])) {
			$height = $this->settings[$name . '_height'];
		} else if ($height == 0) {
			$height = $this->default['height'];
		}

		$this->mainImage = array('name' => $name, 'width' => $width, 'height' => $height, 'crop' => $crop);
    }

    private function setGlobals() {
		global $cc;
		global $db;
		global $classID;
		global $message;
		global $DOCUMENT_ROOT;

		$this->globals['cc'] = $cc;
		$this->globals['db'] = $db;
		$this->globals['classID'] = $classID;
		$this->globals['message'] = $message;
		$this->globals['DOCUMENT_ROOT'] = $DOCUMENT_ROOT;
    }

    private function loadSettings() {
		eval(listQuery("SELECT CustomSettings FROM Sub_Class WHERE Sub_Class_ID='{$this->globals['cc']}'", "\$data[CustomSettings]"));
		$this->settings = $CustomSettings;
    }

    private function checkExist($field_name) {
		if ($_FILES['f_' . $field_name][size] != 0 && $_FILES['f_' . $field_name][type] != '') {
			return true;
		} else {
			return false;
		}
    }

    private function getFilePath($field_name) {
		$photo_path = $this->globals['DOCUMENT_ROOT'] . nc_file_path($this->globals['classID'], $this->globals['message'], $field_name, "");
		return $photo_path;
    }
}

?>