<?php

class Zwe_View_Helper_Gravatar extends Zend_View_Helper_HtmlElement
{

	/**
	 * URL to gravatar service
	 */
	const GRAVATAR_URL = 'http://www.gravatar.com/avatar';
	/**
	 * Secure URL to gravatar service
	 */
	const GRAVATAR_URL_SECURE = 'https://secure.gravatar.com/avatar';

	/**
	 * Gravatar rating
	 */
	const GRAVATAR_RATING_G = 'g';
	const GRAVATAR_RATING_PG = 'pg';
	const GRAVATAR_RATING_R = 'r';
	const GRAVATAR_RATING_X = 'x';

	/**
	 * Options
	 *
	 * @var array
	 */
	protected $_options = array('imgSize' => 80,
                                'defaultImg' => 'wavatar',
                                'rating' => 'g');

	/**
	 * Returns an avatar from gravatar's service.
	 *
	 * @link http://en.gravatar.com/site/implement/images/php/
	 * @throws Zend_View_Exception
	 *
	 * @param string|null $email Valid email adress
	 * @param array $options Options
	 * 'imgSize' height of img to return
	 * 'defaultImg' img to return if email adress has not found
	 * 'rating' rating parametr for avatar
	 * @param array $attribs Attribs for img tag (title, alt etc.)
	 * @param bool $flag Use HTTPS? Default false.
	 * @return string
	 */
	public function gravatar($email = null, $options = array(), $attribs = array(), $flag = false)
	{
		if($email === null)
			return '';

		if(count($options) > 0)
        {
			if(isset($options['imgSize']))
				$this->setImgSize($options['imgSize']);
			if(isset($options['defaultImg']))
				$this->setDefaultImg($options['defaultImg']);
			if(isset($options['rating']))
				$this->setRating($options['rating']);
		}

		$validatorEmail = new Zend_Validate_EmailAddress();
		$validatorResult = $validatorEmail->isValid($email);

		if($validatorResult === false)
			throw new Zend_View_Exception(current($validatorEmail->getMessages()));

		$hashEmail = md5($email);
		$src = $this->getGravatarUrl($flag) . '/' . $hashEmail . '?s=' . $this->getImgSize() . '&d=' . $this->getDefaultImg() . '&r=' . $this->getRating();

		$attribs['src'] = $src;

		$html = '<img' . $this->_htmlAttribs($attribs) . $this->getClosingBracket();

		return $html;
	}

	/**
	 * Gets img size
	 *
	 * @return int The img size
	 */
	public function getImgSize()
	{
		return $this->_options['imgSize'];
	}

	/**
	 * Sets img size
	 *
	 * @throws Zend_View_Exception
	 * @param int $imgSize Size of img must be between 1 and 512
	 * @return Zwe_View_Helper_Gravatar
	 */
	public function setImgSize($imgSize)
	{
		$betweenValidate = new Zend_Validate_Between(1, 512);
		$result = $betweenValidate->isValid($imgSize);
		if (!$result)
			throw new Zend_View_Exception(current($betweenValidate->getMessages()));

		$this->_options['imgSize'] = $imgSize;
		return $this;
	}

	/**
	 * Gets default img
	 *
	 * @return string
	 */
	public function getDefaultImg()
	{
		return $this->_options['defaultImg'];
	}

	/**
	 * Sets default img
	 *
	 * @param string $defaultImg
	 * @return Zwe_View_Helper_Gravatar
	 */
	public function setDefaultImg($defaultImg)
	{
		$this->_options['defaultImg'] = urlencode($defaultImg);
		return $this;
	}

	/**
	 * Gets rating value
	 *
	 * @return string
	 */
	public function getRating()
	{
		return $this->_options['rating'];
	}

	/**
	 * Sets rating value
	 *
	 * @param string $rating Value for rating. Allowed values are: g, px, r,x
     * @return Zwe_View_Helper_Gravatar
     * @throws Zend_View_Exception
	 */
	public function setRating($rating)
	{
		switch ($rating) {
			case self::GRAVATAR_RATING_G:
			case self::GRAVATAR_RATING_PG:
			case self::GRAVATAR_RATING_R:
			case self::GRAVATAR_RATING_X:
				$this->_options['rating'] = $rating;
				break;
			default:
				throw new Zend_View_Exception('The value "' . $rating . '" isn\'t allowed.');
		}

        return $this;
	}

	/**
	 * Gets URL to gravatar's service.
	 *
	 * @param bool $flag Use HTTPS?
	 * @return string Url
	 */
	private function getGravatarUrl($flag)
	{
		return (bool) $flag === false ? self::GRAVATAR_URL : self::GRAVATAR_URL_SECURE;
	}

}