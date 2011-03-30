<?php
/**
 * Description of Float
 *
 * @author aheadley
 */
class NBT_Tag_Float extends NBT_FiniteTag {
  static protected $_tagType = NBT_Tag::TYPE_FLOAT;

  static public function getStructFormat() {
    return 'f';
  }

  static public function getByteCount() {
    return 4;
  }

  static public function parse( $handle ) {
    list(, $value ) = unpack( self::getStructFormat(),
      self::endianTransform( fread( $handle, self::getByteCount() ) ) );
    $tagClass = self::getTypeClass( self::$_tagType );
    return new $tagClass( $value );
  }

  public function write( $handle ) {
    parent::write( $handle );
    if( !fwrite( $handle, pack( self::getStructFormat(),
          self::endianTransform( $this->_data ) ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}
