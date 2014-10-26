<?php
/*
 * Copyright (c) 2014, Josef Kufner  <jk@frozen-doe.net>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace Duf\Renderer\HtmlView;

/**
 * Render field as thumbnail
 */
class Thumbnail implements \Duf\Renderer\IFieldWidgetRenderer
{

	/// @copydoc \Duf\Renderer\IFieldWidgetRenderer::renderFieldWidget
	public static function renderFieldWidget(\Duf\Form $form, $template_engine, $widget_conf, $group_id, $field_id, $field_conf)
	{
		$values = $form->getViewData($group_id);
		if (empty($values[$field_id])) {
			return;
		}
		$value = $values[$field_id];

		if (isset($field_conf['link'])) {
			echo "<a href=\"", htmlspecialchars(filename_format($field_conf['link'], $values)), "\" class=\"thumbnail\">";
		}

		$base_dir = filename_format($field_conf['base_dir'], $values);

		if (parse_url($value, PHP_URL_HOST) == '') {
			$src = "$base_dir/$value";
		} else {
			$src = $value;
		}

		echo "<img width=\"", $widget_conf['width'], "\" height=\"", $widget_conf['height'], "\" class=\"thumbnail\"",
			" src=\"", htmlspecialchars($src), "\" alt=\"\">";

		if (isset($field_conf['link'])) {
			echo "</a>";
		}

		echo "\n";
	}

}

