<?php
/**
 * Description of String
 *
 * @author aheadley
 */
class NBT_Tag_String extends NBT_Tag {
  static protected $_tagType  = self::TYPE_STRING;
  private $_dataLength  = null;

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    $length = NBT_Tag_Short::parse( $handle, false )->get();
    if( $length > 0 ) {
      return new NBT_Tag_String( utf8_decode( fread( $handle, $length ) ), $name );
    } else {
      return new NBT_Tag_String( null, $name );
    }
  }

  public function set( $value ) {
    $this->_dataLength = new NBT_Tag_Short( strlen( $value ) );
    $this->_data = $value;
  }

  public function write( $handle ) {
    parent::write( $handle );
    $value = utf8_encode( $this->_data );
    $length = strlen( $value );
    $this->_dataLength->write( $handle );
    if( !fwrite( $handle, utf8_encode( $this->_data ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}