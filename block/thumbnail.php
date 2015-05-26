<?php
/*
 * Copyright (c) 2011-2014, Josef Kufner  <jk@frozen-doe.net>
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


/**
 * Generate a thumbnail. This block should be used in conjuction with image
 * lists and thumbnail views, which shall reference URL with this thumbnail
 * generator. Use core/send_file template to show this thumbnail.
 */
class B_duf__thumbnail extends \Cascade\Core\Block
{

	protected $inputs = array(
		'filename' => null,	// Other inputs are used as parameters.
		'width' => 512,		// Target size.
		'height' => 512,	// Target size.
		'resize_mode' => 'fit',	// One of: 'fit', 'fill', 'same_height'
		'*' => null,
	);

	protected $outputs = array(
		'thumbnail_file' => true,
		'done' => true,
	);

	public function main()
	{
		$width = $this->in('width');
		$height = $this->in('height');
		$resize_mode = $this->in('resize_mode');
		$filename = realpath(DIR_ROOT.'/'.filename_format($this->in('filename'), $this->inAll()));

		$base_dir = realpath(DIR_ROOT);
		if (strncmp($base_dir, $filename, strlen($base_dir)) !== 0) {
			throw new \InvalidArgumentException(sprintf('Access denied to file "%s", because it is outside "%s".', $filename, $base_dir));
		}

		// prepare cache file
		$cache_dir = DIR_ROOT.'var/cache';
		if (!is_dir($cache_dir)) {
			mkdir($cache_dir);
		}
		$cache_fn = md5($filename.'|'.$width.'|'.$height.'|'.$resize_mode).'.jpg';
		$cache_file = $cache_dir.'/'.substr($cache_fn, 0, 2);
		if (!is_dir($cache_file)) {
			mkdir($cache_file);
		}
		$cache_file .= '/'.$cache_fn;

		// update cache if required
		if (!is_readable($cache_file) || filemtime($filename) > filemtime($cache_file) || filemtime(__FILE__) > filemtime($cache_file)) {
			\Duf\Thumbnail::generateThumbnail($cache_file, $filename, $width, $height, $resize_mode);
		}
		if ($cache_file !== false) {
			$this->out('thumbnail_file', $cache_file);
			$this->out('done', true);
		}
	}

};


