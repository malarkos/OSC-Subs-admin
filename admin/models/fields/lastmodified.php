<?php
jimport('joomla.form.formfield');

/**
 * Supports an HTML form field
*/
class JFormFieldLastModified extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var        string
	 * @since    1.6
	 */
	protected $type = 'lastmodified';

	/**
	 * Method to get the field input lastmodified.
	 *
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		
		$time_updated = date("Y-m-d H:i:s");
		$html = '<input type="hidden" name="'.$this->name.'" value="'.$time_updated.'" />';

		return $html;
	}
}

?>