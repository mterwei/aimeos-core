<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Locale
 */


namespace Aimeos\MShop\Locale\Item\Currency;


/**
 * Default implementation of a currency item.
 *
 * @package MShop
 * @subpackage Locale
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Locale\Item\Currency\Iface
{
	private $values;


	/**
	 * Initializes the currency object object.
	 *
	 * @param array $values Possible params to be set on initialization
	 */
	public function __construct( array $values = [] )
	{
		parent::__construct( 'locale.currency.', $values );

		$this->values = $values;
	}


	/**
	 * Sets the ID of the currency.
	 *
	 * @param string $key ID of the currency
	 * @return \Aimeos\MShop\Locale\Item\Currency\Iface Locale currency item for chaining method calls
	 */
	public function setId( $key )
	{
		return parent::setId( $this->checkCurrencyId( $key ) );
	}


	/**
	 * Returns the code of the currency.
	 *
	 * @return string Code of the currency
	 */
	public function getCode()
	{
		if( isset( $this->values['locale.currency.id'] ) ) {
			return (string) $this->values['locale.currency.id'];
		}

		return '';
	}


	/**
	 * Sets the code of the currency.
	 *
	 * @param string $code Code of the currency
	 * @return \Aimeos\MShop\Locale\Item\Currency\Iface Locale currency item for chaining method calls
	 */
	public function setCode( $code )
	{
		if( $code !== $this->getCode() )
		{
			$this->values['locale.currency.id'] = $this->checkCurrencyId( $code, false );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the label or symbol of the currency.
	 *
	 * @return string Label or symbol of the currency
	 */
	public function getLabel()
	{
		if( isset( $this->values['locale.currency.label'] ) ) {
			return (string) $this->values['locale.currency.label'];
		}

		return '';
	}


	/**
	 * Sets the label or symbol of the currency.
	 *
	 * @param string $label Label or symbol of the currency
	 * @return \Aimeos\MShop\Locale\Item\Currency\Iface Locale currency item for chaining method calls
	 */
	public function setLabel( $label )
	{
		if( (string) $label !== $this->getLabel() )
		{
			$this->values['locale.currency.label'] = (string) $label;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the status of the item.
	 *
	 * @return integer Status of the item
	 */
	public function getStatus()
	{
		if( isset( $this->values['locale.currency.status'] ) ) {
			return (int) $this->values['locale.currency.status'];
		}

		return 1;
	}


	/**
	 * Sets the status of the item.
	 *
	 * @param integer $status Status of the item
	 * @return \Aimeos\MShop\Locale\Item\Currency\Iface Locale currency item for chaining method calls
	 */
	public function setStatus( $status )
	{
		if( (int) $status !== $this->getStatus() )
		{
			$this->values['locale.currency.status'] = (int) $status;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType()
	{
		return 'locale/currency';
	}


	/**
	 * Tests if the item is available based on status, time, language and currency
	 *
	 * @return boolean True if available, false if not
	 */
	public function isAvailable()
	{
		return parent::isAvailable() && $this->getStatus() > 0;
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Locale\Item\Currency\Iface Currency item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'locale.currency.code': $item = $item->setCode( $value ); break;
				case 'locale.currency.label': $item = $item->setLabel( $value ); break;
				case 'locale.currency.status': $item = $item->setStatus( $value ); break;
				default: continue 2;
			}

			unset( $list[$key] );
		}

		return $item;
	}


	/**
	 * Returns the item values as array.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( $private = false )
	{
		$list = parent::toArray( $private );

		$list['locale.currency.code'] = $this->getCode();
		$list['locale.currency.label'] = $this->getLabel();
		$list['locale.currency.status'] = $this->getStatus();

		return $list;
	}
}
