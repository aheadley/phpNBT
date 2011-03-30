<?php
/**
 * Description of Byte
 *
 * @author aheadley
 */
class NBT_Tag_Byte extends NBT_FiniteTag {
  static protected $_tagType = NBT_Tag::TYPE_BYTE;
  
  static public function getStructFormat() {
    return 'c';
  }

  static public function getByteCount() {
    return 1;
  }

  public function __construct( $data, $name = null ) {
    $this->set( $data );
    if( !is_null( $name ) ) {
      $this->_name = new NBT_Tag_String( $name );
    }
  }

  public function set( $value ) {
    $this->_data = $value & 0xFF;
  }

  public function write( $handle ) {
    if( !fwrite( $handle, pack( self::getStructFormat(), $this->_data ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}