<?php
/**
 * Description of ByteArray
 *
 * @author aheadley
 */
class NBT_Tag_ByteArray extends NBT_SequenceTag {
  static protected $_tagType  = NBT_Tag::TYPE_BYTE_ARRAY;
  private $_dataLength  = null;

  static public function parse( $handle ) {
    $length = NBT_Tag_Int::parse( $handle );
    $data = array();
    for( $i = 0; $i < $length->get(); $i++ ) {
      $data[] = NBT_Tag_Byte::parse( $handle );
    }
    return new NBT_Tag_ByteArray( $data );
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
      //TODO: this is probably not write since it would include the tag type
      $byte->write( $handle );
    }
  }
}
