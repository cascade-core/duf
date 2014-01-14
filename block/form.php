<?php
/*
 * Copyright (c) 2010, Josef Kufner  <jk@frozen-doe.net>
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
 * DUF - Declarative Universal Forms. This block contains form logic. Use 
 * duf/show to show the form.
 */

class B_duf__form extends Block {

	protected $inputs = array(
		'form_def' => array(),
		'form_toolbox' => array(),
		'*' => null,
	);

	protected $outputs = array(
		'form' => true,
		'done' => true,
		'*' => true,
	);


	public final function main()
	{
		$form = new \Duf\Form($this->fullId(), $this->in('form_def'), $this->in('form_toolbox'));

		$form->loadInput();

		if ($form->isSubmitted()) {
			$form->useInput();
		} else {
			$form->loadDefaults();
			$form->setDefaults($this->inAll());
			$form->useDefaults();
		}

		$this->outAll($form->getValues());
		$this->out('form', $form);
		$this->out('done', $form->isSubmitted() && $form->isValid());
	}

}

