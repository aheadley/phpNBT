<?php
/**
 * Description of Data
 *
 * @author aheadley
 */
class NBT_Data {
  const VERSION_GZIP    = 1;
  const VERSION_ZLIB    = 2;
  private $_data              = array();
  private $_handle            = null;
  private $_compressionMethod = null;

  public function __construct( $fp,
                                 $compressionMethod = self::VERSION_GZIP ) {
    $this->_handle = $fp;
    $this->_compressionMethod = $compressionMethod;
    $this->_parse();
  }

  public function __toString() {
    //TODO: need to add in compression method here
    return "NBT_Data({$this->_data})";
  }

  public function out() {
    switch( $this->_compressionMethod ) {
      case self::VERSION_GZIP:
        return gzdeflate( $this->_data->out() );
        break;
      case self::VERSION_ZLIB:
        //TODO: no idea here
        throw Exception( 'NYI' );
        break;
    }
  }

  private function _parse() {
    while( !foef( $this->_handle ) &&
            $tagType = $this->_getNextTagType() !== 'NBT_Tag_End' ) {
      $this->_data[] = $tagType::parse( $this->_handle );
    }
  }

  private function _getNextTagType() {
    list(, $tagType ) = unpack( NBT_Tag_Byte::getStructFormat(),
      fread( $this->_handle, NBT_Tag_Byte::getByteCount() ) );
    return NBT_Tag::getTypeClass( $tagType );
  }
}