<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Item\Base\Product\Attribute;


/**
 * Default product attribute item implementation.
 *
 * @package MShop
 * @subpackage Order
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface
{
	private $values;

	/**
	 * Initializes the order product attribute instance.
	 *
	 * @param array $values Associative array of order product attribute values. Possible
	 * keys: 'id', 'ordprodid', 'value', 'code', 'mtime'
	 */
	public function __construct( array $values = [] )
	{
		parent::__construct( 'order.base.product.attribute.', $values );

		$this->values = $values;
	}


	/**
	 * Returns the ID of the site the item is stored
	 *
	 * @return string|null Site ID (or null if not available)
	 */
	public function getSiteId()
	{
		if( isset( $this->values['order.base.product.attribute.siteid'] ) ) {
			return (string) $this->values['order.base.product.attribute.siteid'];
		}
	}


	/**
	 * Sets the site ID of the item.
	 *
	 * @param string $value Unique site ID of the item
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setSiteId( $value )
	{
		if( (string) $value !== $this->getSiteId() )
		{
			$this->values['order.base.product.attribute.siteid'] = (string) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the original attribute ID of the product attribute item.
	 *
	 * @return string Attribute ID of the product attribute item
	 */
	public function getAttributeId()
	{
		if( isset( $this->values['order.base.product.attribute.attributeid'] ) ) {
			return (string) $this->values['order.base.product.attribute.attributeid'];
		}

		return '';
	}


	/**
	 * Sets the original attribute ID of the product attribute item.
	 *
	 * @param string $id Attribute ID of the product attribute item
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setAttributeId( $id )
	{
		if( (string) $id !== $this->getAttributeId() )
		{
			$this->values['order.base.product.attribute.attributeid'] = (string) $id;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the ID of the ordered product as parent
	 *
	 * @return string|null ID of the ordered product
	 */
	public function getParentId()
	{
		if( isset( $this->values['order.base.product.attribute.parentid'] ) ) {
			return (string) $this->values['order.base.product.attribute.parentid'];
		}
	}


	/**
	 * Sets the ID of the ordered product as parent
	 *
	 * @param string $id ID of the ordered product
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setParentId( $id )
	{
		if( (string) $id !== $this->getParentId() )
		{
			$this->values['order.base.product.attribute.parentid'] = (string) $id;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the value of the product attribute.
	 *
	 * @return string Value of the product attribute
	 */
	public function getType()
	{
		if( isset( $this->values['order.base.product.attribute.type'] ) ) {
			return (string) $this->values['order.base.product.attribute.type'];
		}

		return '';
	}


	/**
	 * Sets the value of the product attribute.
	 *
	 * @param string $type Type of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setType( $type )
	{
		if( (string) $type !== $this->getType() )
		{
			$this->values['order.base.product.attribute.type'] = $this->checkCode( $type );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the code of the product attibute.
	 *
	 * @return string Code of the attribute
	 */
	public function getCode()
	{
		if( isset( $this->values['order.base.product.attribute.code'] ) ) {
			return (string) $this->values['order.base.product.attribute.code'];
		}

		return '';
	}


	/**
	 * Sets the code of the product attribute.
	 *
	 * @param string $code Code of the attribute
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setCode( $code )
	{
		if( (string) $code !== $this->getCode() )
		{
			// don't use checkCode() because maximum length is 255 chars
			$this->values['order.base.product.attribute.code'] = (string) $code;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the localized name of the product attribute.
	 *
	 * @return string Localized name of the product attribute
	 */
	public function getName()
	{
		if( isset( $this->values['order.base.product.attribute.name'] ) ) {
			return (string) $this->values['order.base.product.attribute.name'];
		}

		return '';
	}


	/**
	 * Sets the localized name of the product attribute.
	 *
	 * @param string $name Localized name of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setName( $name )
	{
		if( (string) $name !== $this->getName() )
		{
			$this->values['order.base.product.attribute.name'] = (string) $name;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the value of the product attribute.
	 *
	 * @return string|array Value of the product attribute
	 */
	public function getValue()
	{
		if( isset( $this->values['order.base.product.attribute.value'] ) ) {
			return $this->values['order.base.product.attribute.value'];
		}

		return '';
	}


	/**
	 * Sets the value of the product attribute.
	 *
	 * @param string|array $value Value of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setValue( $value )
	{
		if( $value !== $this->getValue() )
		{
			$this->values['order.base.product.attribute.value'] = $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the quantity of the product attribute.
	 *
	 * @return integer Quantity of the product attribute
	 */
	public function getQuantity()
	{
		if( isset( $this->values['order.base.product.attribute.quantity'] ) ) {
			return (int) $this->values['order.base.product.attribute.quantity'];
		}

		return 1;
	}


	/**
	 * Sets the quantity of the product attribute.
	 *
	 * @param integer $value Quantity of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function setQuantity( $value )
	{
		if( (int) $value !== $this->getQuantity() )
		{
			$this->values['order.base.product.attribute.quantity'] = (int) $value;
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
		return 'order/base/product/attribute';
	}


	/**
	 * Copys all data from a given attribute item.
	 *
	 * @param \Aimeos\MShop\Attribute\Item\Iface $item Attribute item to copy from
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order base product attribute item for chaining method calls
	 */
	public function copyFrom( \Aimeos\MShop\Attribute\Item\Iface $item )
	{
		$this->setSiteId( $item->getSiteId() );
		$this->setAttributeId( $item->getId() );
		$this->setName( $item->getName() );
		$this->setCode( $item->getType() );
		$this->setValue( $item->getCode() );

		$this->setModified();

		return $this;
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'order.base.product.attribute.siteid': !$private ?: $item = $item->setSiteId( $value ); break;
				case 'order.base.product.attribute.attrid': !$private ?: $item = $item->setAttributeId( $value ); break;
				case 'order.base.product.attribute.parentid': !$private ?: $item = $item->setParentId( $value ); break;
				case 'order.base.product.attribute.type': $item = $item->setType( $value ); break;
				case 'order.base.product.attribute.code': $item = $item->setCode( $value ); break;
				case 'order.base.product.attribute.value': $item = $item->setValue( $value ); break;
				case 'order.base.product.attribute.name': $item = $item->setName( $value ); break;
				case 'order.base.product.attribute.quantity': $item = $item->setQuantity( $value ); break;
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

		$list['order.base.product.attribute.type'] = $this->getType();
		$list['order.base.product.attribute.code'] = $this->getCode();
		$list['order.base.product.attribute.name'] = $this->getName();
		$list['order.base.product.attribute.value'] = $this->getValue();
		$list['order.base.product.attribute.quantity'] = $this->getQuantity();

		if( $private === true )
		{
			$list['order.base.product.attribute.attrid'] = $this->getAttributeId();
			$list['order.base.product.attribute.parentid'] = $this->getParentId();
		}

		return $list;
	}
}
