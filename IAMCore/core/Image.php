<?php
namespace Iam;

use Iam\Listen;

class Image
{
	public $path = '';
	/**
	 * 图片加水印
	 * @param string $postion l_t, l_b, r_t, r_b, c_c, 5_5, 50%,60%
	 */
	public function imageMark($image, $img_mark, $postion = [ 'left' => 0, 'right' => 0, 'vertical' => 0, 'horizontal' => 0, 'top' => 0, 'bottom' => 0 ])
	{
		/**
		 * 图片格式不能加水印
		 */
		if (!$_image = $this->getImage(ROOT_PATH . $image)) {
			return;
		}
		if (!$_img_mark = $this->getImage(ROOT_PATH . $img_mark)) {
			return;
		}

		$_image_width = $_image[0];
		$_image_height = $_image[1];
		
		$_img_mark_width = $_img_mark[0];
		$_img_mark_height = $_img_mark[1];

		// $postion = preg_replace('/[lrtb]/', '0', $postion);
		// $postion = str_replace('c', '50%', $postion);

		// $pos = explode('_', $postion);
		// $dst_x = 0;
		// $dst_y = 0;
		
		// if (is_numeric($pos[0])) {
		//     $dst_x = $pos[0];
		// } else {
		//     $_pos_0 = explode('%', $pos[0]);
		//     if (count($_pos_0) != 2) {
		//         return;
		//     }
		//     $dst_x = $_pos_0[0] * ($_image_width - $_img_mark_width) / 100;
		// }

		imagecopy($_image['source'], $_img_mark['source'], $_image_width - $_img_mark_width, $_image_height - $_img_mark_height, 0, 0, $_img_mark_width, $_img_mark_height);
		imagedestroy($_img_mark['source']);
		return $this->createNewImage($_image['source'], $image, $_image);
	}

	/**
	 * 保存到本地
	 */
	private function createNewImage($newImg, $newName, $imgInfo){
		$newPath = ROOT_PATH . $newName;
		switch ($imgInfo['mime']) {
			case 'image/gif':       //gif
				$result = imageGIF($newImg, $newPath);
				break;
			case 'image/jpeg':       //jpg
				$result = imageJPEG($newImg, $newPath);
				break;
			case 'image/png':       //png
				$result = imagePng($newImg, $newPath);
				break;
		}

		imagedestroy($newImg);
		return $newName;
	}

	/**
	 * 格式化坐标和宽高-待完善
	 */
	public function parseSize($scl, $num1, $num2)
	{
		if (is_numeric($scl)) {
		    return $scl;
		} else {
		    $_pos_0 = explode('%', $pos[0]);
		    if (count($_pos_0) != 2) {
		        return;
		    }
		    $dst_x = $_pos_0[0] * ($_image_width - $_img_mark_width) / 100;
		}
	}

	/**
	 * 获取图片信息
	 */
	function getImage($source_path)
	{
		$source_info = getimagesize($source_path);
		$source_mime = $source_info['mime'];
		switch ($source_mime)
		{
			case 'image/gif':
			$source_image = imagecreatefromgif($source_path);
			break;

		case 'image/jpeg':
			$source_image = imagecreatefromjpeg($source_path);
			break;

		case 'image/png':
			$source_image = imagecreatefrompng($source_path);
			break;

		default:
			return false;
			break;
		}
		$source_info['source'] = $source_image;
		return $source_info;
	}
}
