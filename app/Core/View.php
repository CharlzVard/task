<?php

namespace App\Core;

class View
{
	function generate($content_view, $template_view, $data = null)
	{
		include dirname(__DIR__, 2) . "/views/" . $template_view;
	}
}
