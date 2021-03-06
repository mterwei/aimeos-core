<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Index\Manager\Catalog;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $object;


	protected function setUp()
	{
		$this->context = \TestHelperMShop::getContext();
		$this->object = new \Aimeos\MShop\Index\Manager\Catalog\Standard( $this->context );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->context );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testAggregate()
	{
		$item = \Aimeos\MShop::create( $this->context, 'catalog' )->findItem( 'cafe' );

		$search = $this->object->createSearch( true );
		$result = $this->object->aggregate( $search, 'index.catalog.id' );

		$this->assertEquals( 4, count( $result ) );
		$this->assertArrayHasKey( $item->getId(), $result );
		$this->assertEquals( 2, $result[$item->getId()] );
	}


	public function testGetResourceType()
	{
		$result = $this->object->getResourceType();

		$this->assertContains( 'index/catalog', $result );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute ) {
			$this->assertInstanceOf( \Aimeos\MW\Criteria\Attribute\Iface::class, $attribute );
		}
	}


	public function testSaveDeleteItem()
	{
		$productManager = \Aimeos\MShop\Product\Manager\Factory::create( $this->context );
		$product = $productManager->findItem( 'CNC' );

		$catalogManager = \Aimeos\MShop\Catalog\Manager\Factory::create( $this->context );
		$listManager = $catalogManager->getSubManager( 'lists' );
		$search = $listManager->createSearch( true );
		$search->setConditions( $search->compare( '==', 'catalog.lists.domain', 'product' ) );
		$catListItems = $listManager->searchItems( $search );

		if( ( $catListItem = reset( $catListItems ) ) === false ) {
			throw new \RuntimeException( 'No catalog list item found!' );
		}


		$product = $productManager->saveItem( $product->setId( null )->setCode( 'ModifiedCNC' ) );
		$catListItem = $listManager->saveItem( $catListItem->setId( null )->setRefId( $product->getId() ) );

		$this->object->saveItem( $product );


		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'index.catalog.id', $catListItem->getParentId() ) );
		$result = $this->object->searchItems( $search );


		$this->object->deleteItem( $product->getId() );
		$productManager->deleteItem( $product->getId() );
		$listManager->deleteItem( $catListItem->getId() );


		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'index.catalog.id', $catListItem->getParentId() ) );
		$result2 = $this->object->searchItems( $search );


		$this->assertContains( $product->getId(), array_keys( $result ) );
		$this->assertFalse( in_array( $product->getId(), array_keys( $result2 ) ) );
	}


	public function testGetSubManager()
	{
		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->getSubManager( 'unknown' );
	}


	public function testSearchItemsId()
	{
		$catalogManager = \Aimeos\MShop\Catalog\Manager\Factory::create( $this->context );
		$id = $catalogManager->findItem( 'cafe' )->getId();

		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'index.catalog.id', $id ) );
		$result = $this->object->searchItems( $search, [] );

		$this->assertEquals( 2, count( $result ) );
	}


	public function testSearchItemsNoId()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '!=', 'index.catalog.id', null ) );
		$result = $this->object->searchItems( $search, [] );

		$this->assertEquals( 9, count( $result ) );
	}


	public function testSearchItemsPosition()
	{
		$catalogManager = \Aimeos\MShop\Catalog\Manager\Factory::create( $this->context );
		$id = $catalogManager->findItem( 'cafe' )->getId();

		$search = $this->object->createSearch();

		$search->setConditions( $search->combine( '&&', [
			$search->compare( '>=', $search->createFunction( 'index.catalog:position', ['promotion', $id] ), 0 ),
			$search->compare( '>=', $search->createFunction( 'index.catalog:position', ['promotion', [$id]] ), 0 ),
		] ) );

		$search->setSortations( [
			$search->sort( '+', $search->createFunction( 'sort:index.catalog:position', ['promotion', [$id]] ) ),
			$search->sort( '+', $search->createFunction( 'sort:index.catalog:position', ['promotion', $id] ) ),
		] );

		$result = $this->object->searchItems( $search, [] );

		$this->assertEquals( 2, count( $result ) );
	}


	public function testCleanupIndex()
	{
		$this->object->cleanupIndex( '1970-01-01 00:00:00' );
	}

}
