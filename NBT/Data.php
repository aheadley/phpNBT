<?php
/**
 * Description of Data
 *
 * @author aheadley
 */
class NBT_Data {
  const VERSION_GZIP    = 1;
  const VERSION_DEFLATE = 2;
  private $data = null;
  private $compressionMethod = null;

  public function __construct( $data = null,
                                 $compressionMethod = self::VERSION_GZIP ) {
    if( is_null( $data ) ) {
      $this->_data = new NBT_Tag_Compound( null, 'Data' );
    } else {
      $this->_in( $data );
    }
  }

  public function __toString() {
    return (string)$this->_data;
  }

  public function out() {
    switch( $this->_compressionMethod ) {
      case self::VERSION_GZIP:
        return gzdeflate( $this->_data->out() );
        break;
      case self::VERSION_DEFLATE:
        //TODO: no idea here
        throw Exception( 'NYI' );
        break;
    }
  }

  private function _in( $compressedData ) {
    $this->_data = new NBT_Tag_Compound( $compressedData );
  }
}