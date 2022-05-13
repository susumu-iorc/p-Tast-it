<?php
foreach ( glob( 'parts/*.php' ) as $filename )
{
  include_once $filename;
}
