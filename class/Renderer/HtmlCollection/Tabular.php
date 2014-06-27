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

namespace Duf\Renderer\HtmlCollection;

/**
 * Render collection into HTML `<table>` with additional control elements 
 * around. Multi-dimensional collections are flattened into simple list of 
 * table rows.
 */
class Tabular implements \Duf\Renderer\IWidgetRenderer
{

	/// @copydoc \Duf\Renderer\IWidgetRenderer::renderWidget
	public static function renderWidget(\Duf\Form $form, $template_engine, $widget_conf)
	{
		$group_id = $widget_conf['group_id'];
		$group = $form->getFieldGroup($group_id);

		if (!isset($widget_conf['columns'])) {
			throw new InvalidArgumentException('Missing columns configuration.');
		}
		$columns = $widget_conf['columns'];

		// Begin
		echo "<table";
		$class = isset($widget_conf['class']) ? (array) $widget_conf['class'] : array();
		$class[] = 'duf_table';
		echo " class=\"", htmlspecialchars(join(' ', $class)), "\"";
		echo ">\n";

		if (!empty($widget_conf['caption'])) {
			echo "<caption>", htmlspecialchars($widget_conf['caption']), "</caption>\n";
		}

		// Header
		echo "<thead>\n";
		echo "<tr>\n";
		foreach ($columns as $c => $col) {
			echo "<th>";
			if (isset($col['thead']['widgets'])) {
				$form->renderWidgets($template_engine, $col['thead']['widgets']);
			}
			echo "</th>\n";
		}
		echo "</tr>\n";
		echo "</thead>\n";

		// Footer
		echo "<tfoot>\n";
		echo "</tfoot>\n";

		// Collection - table body
		echo "<tbody>\n";
		$items = $form->getRawData($group_id);
		$collection_key = array();
		self::walkCollection($form, $template_engine, $widget_conf, $columns, $group_id,
			$items, $group['collection_dimensions'], 0, $collection_key);
		$form->unsetCollectionKey($group_id);
		echo "</tbody>\n";

		// End
		echo "</table>\n";
	}


	private static function walkCollection($form, $template_engine, $widget_conf, $columns, $group_id, $items, $remaining_depth, $depth, & $collection_key)
	{
		if ($remaining_depth > 0) {
			// We need to go deeper ...
			foreach($items as $i => $item) {
				$collection_key[$depth] = $i;
				self::walkCollection($form, $template_engine, $widget_conf, $columns, $group_id,
					$item, $remaining_depth - 1, $depth + 1, $collection_key);
			}
		} else {
			// Deep enough.
			$form->setCollectionKey($group_id, $collection_key);
			echo "<tr>\n";
			foreach ($columns as $c => $col) {
				echo "<td>";
				if (isset($col['tbody']['widgets'])) {
					$form->renderWidgets($template_engine, $col['tbody']['widgets']);
				}
				echo "</td>\n";
			}
			echo "</tr>\n";
		}
	}

}

