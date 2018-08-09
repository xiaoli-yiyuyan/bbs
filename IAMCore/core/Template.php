<?php
namespace Iam;

use Iam\Listen;
use Iam\ext\simple_html_dom;

class Template
{
	private $php = [
		'begin' => '<?php ',
		'end' => '; ?>'
	];

	public function test()
	{
		$html = file_get_contents('tpl/test.html');
		$html = new simple_html_dom($html);
		$var = $html->find('i-var');
		foreach ($var as $item) {
			$name = $item->attr['name'];
			$value = $item->attr['value'];
			$type = $item->attr['type'];
			if ($type == 'get') {
				$value = "Request::get('$name', '$value')";
			} elseif ($type == 'post') {
				$value = "Request::post('$name', '$value')";
			} else {
				// $value = $value['value'];
			}

			$item->outertext = $this->php['begin'] . '$' . $name . '=' . $value . $this->php['end'];
		}
		$source = $html->find('i-source');
		foreach ($source as $item) {
			$name = $item->attr['name'];
			$class = $item->attr['class'];
			$action = $item->attr['action'];
			$options = json_decode($item->attr['options'], true);
			$options = var_export($options, true);
			$item->outertext = $this->php['begin'] . "(new $class)->$action($options)" . $this->php['end'];
		}

		$load = $html->find('i-load');
		foreach ($load as $item) {

		}


		$html->save('result.php');
		echo $html;
	}

	private function includeParse()
	{
		/**
		 * {var name="name" value="1" type="value"}
		 * {var name="page" value="1" type="get"}
		 */
		// {load src="/componemts/common/index_link" name="1" path="5"}
		/**
		 * {foreach list="item,key"}
		 * {/foreach}
		 */
	}

}
