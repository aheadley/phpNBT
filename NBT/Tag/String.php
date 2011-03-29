<?php
/**
 * Description of String
 *
 * @author aheadley
 */
class NBT_Tag_String extends NBT_Tag {
  static private $_tagType = NBT_Tag::TYPE_STRING;

  private $_dataLength  = null;

  static public function parse( $handle ) {
    return new NBT_Tag_String( utf8_decode( fread( $handle,
      NBT_Tag_Short::parse( $handle )->get() ) ) );
  }

  public function set( $value ) {
    $this->_dataLength = NBT_Tag_Short( strlen( $value ) );
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