<?php
/**
* @version 			CPF 1.0
* @package			Validador de CPF
* @url				http://lablivre.org
* @editor			Leandro Cunha
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// Plugin

class plgCCK_Field_ValidationCpf extends JCckPluginValidation
{
	protected static $type	=	'cpf';
	protected static $regex	=	'/^[0-9]+$/';

	// -------- -------- -------- -------- -------- -------- -------- -------- // Prepare

	// onCCK_Field_ValidationPrepareForm
	public static function onCCK_Field_ValidationPrepareForm( &$field, $fieldId, &$config )
	{
		if ( self::$type != $field->validation ) {
			return;
		}
		$plgconf = parent::g_getValidation( $field->validation_options );
		
		$validation	=	parent::g_onCCK_Field_ValidationPrepareForm( $field, $fieldId, $config, 'regex', self::$regex );
		print_r($plgconf);
		$field->validate[]	=	'custom['.$validation->name.']';
		//self::_setError( $process['name'], $config );
	}
	
	public static function onCCK_FieldBeforeRenderForm( $process, &$fields, &$storages, &$config = array() )
	{
		//
	}


			// onCCK_FieldBeforeStore
	public static function onCCK_FieldBeforeStore( $process, &$fields, &$storages, &$config = array() )
	{
		
	}

	// onCCK_Field_ValidationPrepareStore
	public static function onCCK_Field_ValidationPrepareStore( &$field, $name, $value, &$config )
	{
		$plgconf = parent::g_getValidation( $field->validation_options );
		$app	=	JFactory::getApplication();
		$lang	=	JFactory::getLanguage();
		JLoader::Register('VALIDATE',JPATH_PLUGINS.'/cck_field_validation/cpf/includes/class_VALIDATE.php');
		$cpf = new VALIDATE;
		if($plgconf->tipo == 'cnpj'){
			if(!$cpf->cnpj($value)){
				$app->enqueueMessage( "CNPJ Inválido! - " .$name, 'error' );
				$config['validate']	=	'error';
			}
		}else{
			if(!$cpf->cpf($value)){
				$app->enqueueMessage( "CPF Inválido! - " .$name, 'error' );
				$config['validate']	=	'error';
			}
		}
	}


}
?>
