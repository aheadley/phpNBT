<?php
/**
 * Description of ByteArray
 *
 * @author aheadley
 */
class NBT_Tag_ByteArray extends NBT_SequenceTag {
  static protected $_tagType  = self::TYPE_BYTE_ARRAY;
  private $_dataLength  = null;

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    $length = NBT_Tag_Int::parse( $handle );
    $data = array();
    for( $i = 0; $i < $length->get(); $i++ ) {
      $data[] = NBT_Tag_Byte::parse( $handle, false );
    }
    return new NBT_Tag_ByteArray( $data, $name );
  }

  public function __construct( array $data, $name = null ) {
    parent::__construct( $data, $name );
  }

  public function set( array $value ) {
    foreach( $value as $tag ) {
      if( $tag->getType() !== NBT_Tag::TYPE_BYTE ) {
        throw new NBT_Tag_Exception( "Invalid tag type for byte array: " . get_class( $tag ) );
      }
    }
    $this->_dataLength = new NBT_Tag_Int( count( $value ) );
    $this->_data = $value;
  }

  public function write( $handle ) {
    parent::write( $handle );
    $this->_dataLength->write( $handle );
    foreach( $this->_data as $byte ) {
      $byte->write( $handle, false );
    }
  }
}
