<?php
/**
 * Description of List
 *
 * @author aheadley
 */
class NBT_Tag_List extends NBT_SequenceTag {
  static protected $_tagType  = NBT_Tag::TYPE_LIST;
  private $_containingType  = null;
  private $_dataLength      = null;

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    $containingType = NBT_Tag_Byte::parse( $handle, false )->get();
    $containingTypeClass = NBT_Tag::getTypeClass( $containingType );
    $length = NBT_Tag_Int::parse( $handle, false )->get();
    $data = array();
    for( $i = 0; $i < $length; $i++ ) {
      $data[] = $containingTypeClass::parse( $handle, false );
    }
    return new NBT_Tag_List( $containingType, $data, $name );
  }

  public function __construct( $containingType, array $data, $name = null ) {
    parent::__construct( $data, $name );
    $this->_containingType = $containingType;
  }

  public function offsetExists( $offset ) {
    if( !is_int( $offset ) || $offset < 0 ) {
      return false;
    } else {
      return parent::offsetExists( $offset );
    }
  }

  public function offsetSet( $offset, NBT_Tag $value ) {
    if( $this->_containingType !== $value->getType() ) {
      throw new NBT_Tag_Exception( "Invalid tag type for tag list: " . get_class( $value ) );
    } elseif( !is_int( $offset ) || $offset < 0 ) {
      throw new NBT_Tag_Exception( "Invalid offset for tag list: {$offset}" );
    } else {
      parent::offsetSet( $offset, $value );
    }
  }

  public function set( $value ) {
    foreach( $value as $tag ) {
      if( $tag->getType() !== $this->_containingType ) {
        throw new NBT_Tag_Exception( "Invalid tag type for tag list: " . get_class( $tag ) );
      }
    }
    $this->_dataLength = new NBT_Tag_Int( count( $value ) );
    $this->_data = $value;
  }

  public function write( $handle ) {
    parent::write( $handle );
    $this->_containingType->write( $handle );
    $this->_dataLength->write( $handle );
    foreach( $this->_data as $tag ) {
      $tag->write( $handle );
    }
  }
}
