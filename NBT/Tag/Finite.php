<?php
/**
 * Description of Finite
 *
 * @author aheadley
 */
abstract class NBT_Tag_Finite extends NBT_Tag {
  abstract static public function getStructFormat();
  abstract static public function getByteCount();

  static public function parse( $handle ) {
    list(, $data ) = unpack( self::getStructFormat(), fread( $handle, self::getByteCount() ) );
    $tagClass = self::getTypeClass( $data );
    return new $tagClass( $data );
  }

  public function write( $handle ) {
    parent::write( $handle );
    if( !fwrite( $handle, pack( self::getStructFormat(), $this->_data ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}