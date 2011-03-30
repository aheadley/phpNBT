<?php
/**
 * Description of Finite
 *
 * @author aheadley
 */
abstract class NBT_FiniteTag extends NBT_Tag {
  const ENDIAN_BIG    = 1;
  const ENDIAN_LITTLE = 2;

  static private $_endianness = null;
  
  abstract static public function getStructFormat();
  abstract static public function getByteCount();

  static public function parse( $handle ) {
    list(, $data ) = unpack( self::getStructFormat(),
      fread( $handle, self::getByteCount() ) );
    $tagClass = self::getTypeClass( self::$_tagType );
    return new $tagClass( $data );
  }

  public function write( $handle ) {
    parent::write( $handle );
    if( !fwrite( $handle, pack( self::getStructFormat(), $this->_data ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }

  static protected function endianTransform( $data ) {
    if( self::_isLittleEndian() ) {
      return strrev( $data );
    } else {
      return $data;
    }
  }

  static private function _isBigEndian() {
    if( is_null( self::$_endianness ) ) {
      self::$_endianness = pack('d', 1) == "\77\360\0\0\0\0\0\0";
    }
    return self::$_endianness;
  }

  static private function _isLittleEndian() {
    return !self::_isBigEndian();
  }
}