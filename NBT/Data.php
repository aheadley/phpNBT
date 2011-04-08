<?php
/**
 * Description of Data
 *
 * @author aheadley
 */
class NBT_Data {
  const VERSION_GZIP    = 1;
  const VERSION_ZLIB    = 2;
  private $_data        = array();
  private $_position    = null;

  public function __construct( $handle ) {
    $this->_position = ftell( $handle );
    $this->_parse( $handle );
  }

  public function __toString() {
    return "NBT_Data({$this->_data})";
  }

  public function getData() {
    return $this->_data;
  }

  public function write( $handle ) {
    fseek( $handle, $this->_position );
    $this->_data->write( $handle );
  }

  private function _parse( $handle ) {
    while( !feof( $handle ) ) {
      $tagType = NBT_Tag::getTypeClass(
        NBT_Tag_Byte::parse( $handle, false )->get() );
      if( $tagType !== 'NBT_Tag_End' ) {
        $this->_data[] = $tagType::parse( $handle, true );
      } else {
        $this->_data[] = new NBT_Tag_End();
        break;
      }
    }
  }
}