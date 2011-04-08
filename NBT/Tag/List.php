<?php
/**
 * Description of List
 *
 * @author aheadley
 */
class NBT_Tag_List extends NBT_SequenceTag {
  static protected $_tagType  = self::TYPE_LIST;

  private $_containingType  = null;
  private $_dataLength      = null;

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    $containingType = NBT_Tag_Byte::parse( $handle, false );
    $containingTypeClass = NBT_Tag::getTypeClass( $containingType->get() );
    $length = NBT_Tag_Int::parse( $handle, false )->get();
    $data = array();
    for( $i = 0; $i < $length; $i++ ) {
      $data[] = $containingTypeClass::parse( $handle, false );
    }
    return new NBT_Tag_List( $containingType, $data, $name );
  }

  public function __construct( NBT_Tag_Byte $containingType, array $data, $name = null ) {
    $this->_containingType = $containingType;
    parent::__construct( $data, $name );
  }

  public function offsetSet( $offset, $value ) {
    if( !$value instanceof NBT_Tag ) {
      throw new NBT_Tag_Excpetion( "Tag list can only contain other tags" );
    } elseif( $this->_containingType->get() !== $value->getTypeId() ) {
      throw new NBT_Tag_Exception( "Invalid tag type for tag list: " . get_class( $value ) );
    } elseif( !is_int( $offset ) || $offset < 0 ) {
      throw new NBT_Tag_Exception( "Invalid offset for tag list: {$offset}" );
    } else {
      parent::offsetSet( $offset, $value );
    }
  }

  public function set( $value ) {
    foreach( $value as $tag ) {
      if( $tag->getTypeId() !== $this->_containingType->get() ) {
        throw new NBT_Tag_Exception( sprintf( 'Invalid tag type for %s<%s>: %s',
          get_class( $this ), self::getTypeClass( $this->_containingType->get() ),
          get_class( $tag ) ) );
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
      $tag->write( $handle, false );
    }
  }
}
