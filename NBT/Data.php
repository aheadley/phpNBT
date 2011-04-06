<?php
/**
 * Description of Data
 *
 * @author aheadley
 */
class NBT_Data {
  const VERSION_GZIP    = 1;
  const VERSION_ZLIB    = 2;
  private $_data              = null;
  private $_handle            = null;
  private $_handlePosition    = null;
  private $_compressionMethod = null;

  public function __construct( $handle,
                                 $compressionMethod = self::VERSION_GZIP ) {
    $this->_handle = &$handle;
    $this->_handlePosition = ftell( $this->_handle );
    $this->_compressionMethod = $compressionMethod;
    $this->_parse();
  }

  public function __toString() {
    return "NBT_Data:{$this->_compressionMethod}({$this->_data})";
  }

  private function _parse() {
    while( !feof( $this->_handle ) ) {
      $tagType = $this->_getNextTagType();
      if( $tagType !== 'NBT_Tag_End' ) {
        $this->_data[] = $tagType::parse( $this->_handle, true );
      } else {
        $this->_data[] = new NBT_Tag_End();
        break;
      }
    }
  }

  private function _getNextTagType() {
    return NBT_Tag::getTypeClass( NBT_Tag_Byte::parse( $this->_handle, false )->get() );
  }
}