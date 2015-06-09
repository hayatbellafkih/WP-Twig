<?php

class DeviseExtension extends Twig_Extension
{
	public function getFilters()
	{
		return array(
				new Twig_SimpleFilter('device', array($this, 'deviceFilter')),
		);
	}

	public function deviceFilter($number, $device=' DH')
	{
		return $number.$device;
	}

	public function getName()
	{
		return 'app_extension';
	}
}

?>