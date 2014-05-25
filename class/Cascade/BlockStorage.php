<?php
/*
 * Copyright (c) 2012, Josef Kufner  <jk@frozen-doe.net>
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

namespace Duf\Cascade;

/**
 * Generate block for each form.
 */
class BlockStorage {


	/**
	 * Constructor will get options from core.ini.php file.
	 *
	 * Arguments:
	 * 	$storage_opts - Options loaded from config file
	 * 	$context - Common default context (dependency injection 
	 *		container) passed to all storages, and later also to 
	 *		all blocks.
	 *	$alias - Name of the storage (use it in error messages)
	 */
	public function __construct($storage_opts, $context, $alias);

	/**
	 * Returns true if there is no way that this storage can modify or 
	 * create blocks. When creating or modifying block, first storage that 
	 * returns true will be used.
	 */
	public function isReadOnly()
	{
		return true;
	}


	/**
	 * Create instance of requested block and give it loaded configuration. 
	 * No further initialisation here, that is job for cascade controller. 
	 * Returns created instance or false.
	 */
	public function createBlockInstance ($block);


	/**
	 * Describe block for documentation generator.
	 *
	 * Returns structure similar to JSON files in which composed blocks are 
	 * stored.
	 *
	 * In contrast to loadBlock() method, the describeBlock() may return 
	 * significantly modified structure. Or completely artificial structure 
	 * generated only for documentation purposes.
	 *
	 * @warning Never pass result of describeBlock() to storeBlock().
	 *
	 * TODO: Document the documentation structure.
	 */
	public function describeBlock ($block)
	{
		return array();
	}


	/**
	 * Load block configuration. Returns false if block is not found.
	 *
	 * Structure returned by loadBlock() can be directly stored by 
	 * storeBlock(). The block editors are expected to load a block using 
	 * loadBlock(), modify the structure, and then store it back using 
	 * storeBlock(). Therefore, loadBlock() and storeBlock() are 
	 * complementary pair.
	 */
	public function loadBlock ($block)
	{
	}


	/**
	 * Store block configuration.
	 *
	 * Use loadBlock() to retrive block configuration, or create a new 
	 * block.
	 */
	public function storeBlock ($block, $config);


	/**
	 * Delete block configuration.
	 */
	public function deleteBlock ($block);


	/**
	 * Get time (unix timestamp) of last modification of the block.
	 */
	public function blockMTime ($block);


	/**
	 * List all available blocks in this storage.
	 */
	public function getKnownBlocks (& $blocks = array());

}

