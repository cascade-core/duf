<?php
/*
 * Copyright (c) 2013, Josef Kufner  <jk@frozen-doe.net>
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

namespace Duf;

/**
 * Form gets everything it needs from this toolbox.
 *
 * Renderers starting with '@' are field renderers.
 *
 * FIXME: Update docs.
 *
 * TODO: Check class interfaces.
 *
 */
class Toolbox
{
	/**
	 * Toolbox configuration
	 */
	protected $config;

	/**
	 * Context
	 */
	protected $context;


	/**
	 * Create a toolbox.
	 */
	public function __construct($config, $context)
	{
		$this->config = $config;
		$this->context = $context;
	}


	/**
	 * Use field group generator to generate complete field group from
	 * its partial definition.
	 */
	public function updateFieldGroup($generator_name, & $field_group)
	{
		if (isset($this->config['field_group_generators'][$generator_name])) {
			$generator = $this->config['field_group_generators'][$generator_name];
			return $generator::updateFieldGroup($field_group, $this->context);
		}
		throw new \RuntimeException('Unknown field group generator: '.$generator_name);
	}


	/**
	 * Retrieve validator for given field type.
	 *
	 * @return `array('validator_name' => 'Duf\FieldValidator\IFieldValidator class name'))`
	 */
	public function getFieldValidators($field_type)
	{
		if (isset($this->config['field_types'][$field_type]['validators'])) {
			return $this->config['field_types'][$field_type]['validators'];
		}
		throw new ValidatorException('Undefined field validators. Field type: '.$field_type);
	}


	/**
	 * Retrieve value processor for given field type.
	 */
	public function getFieldValueProcessor($field_type)
	{
		if (!isset($this->config['field_types'][$field_type])) {
			throw new ValidatorException('Undefined field type: '.$field_type);
		}
		if (isset($this->config['field_types'][$field_type]['value_processor'])) {
			return $this->config['field_types'][$field_type]['value_processor'];
		} else {
			return null;
		}
	}


	/**
	 * Retrieve form renderer.
	 *
	 * @return `function($form, $template_engine)`
	 */
	public function getFormRenderer($renderer)
	{
		if (isset($this->config['form']['renderers'][$renderer])) {
			return $this->config['form']['renderers'][$renderer];
		}
		throw new RendererException('Undefined form renderer: '.$renderer);
	}


	/**
	 * Retrieve widget renderer.
	 *
	 * @return `function($form, $template_engine, $widget_conf)`
	 */
	public function getWidgetRenderer($widget_shebang)
	{
		if (isset($this->config['widgets'][$widget_shebang]['renderer'])) {
			return $this->config['widgets'][$widget_shebang]['renderer'];
		}
		throw new RendererException('Undefined widget renderer: '.$widget_shebang);
	}


	/**
	 * Get common renderers for all fields in form. These should be added 
	 * to field-specific renderes of each field. Exact ordering of 
	 * renderers after merge is not specified.
	 */
	public function getFormCommonFieldRenderers()
	{
		if (isset($this->config['form']['common_field_renderers'])) {
			return $this->config['form']['common_field_renderers'];
		} else {
			return array();
		}
	}


	/**
	 * Retrieve layout renderer by layout type.
	 *
	 * @return `function($form, $layout_def, $template_engine)`
	 */
	public function getLayoutRenderer($layout_type)
	{
		if (isset($this->config['layouts'][$layout_type]['renderer'])) {
			return $this->config['layouts'][$layout_type]['renderer'];
		}
		throw new RendererException('Undefined layout renderer. Layout type: '.$layout_type);
	}


	/**
	 * Retrieve field renderers. Each field has multiple renderers, i.e. 
	 * one for label, another for input or errors.
	 *
	 * @return `array($renderer_name => function($form, $group_id, 
	 *		$field_id, $field_def, $value, $errors, $template_engine)))`
	 */
	public function getFieldRenderers($field_type)
	{
		if (isset($this->config['field_types'][$field_type]['renderers'])) {
			return $this->config['field_types'][$field_type]['renderers'];
		}
		throw new RendererException('Undefined field renderers. Field type: '.$field_type);
	}


	/**
	 * Retrieve field renderer.
	 * 
	 * @return `array($renderer_name => function($form, $group_id, 
	 *		$field_id, $field_def, $value, $errors, $template_engine)))`
	 */
	public function getFieldRenderer($field_type, $renderer_name)
	{
		if (isset($this->config['field_types'][$field_type]['renderers'][$renderer_name])) {
			return $this->config['field_types'][$field_type]['renderers'][$renderer_name];
		}
		if (isset($this->config['form']['common_field_renderers'][$renderer_name])) {
			return $this->config['form']['common_field_renderers'][$renderer_name];
		}
		throw new RendererException('Undefined field renderer "'.$renderer_name.'". Field type: '.$field_type);
	}

}

