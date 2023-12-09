<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Contentwarehouse;

class QualitySalientTermsSalientTerm extends \Google\Collection
{
  protected $collection_key = 'signalTerm';
  /**
   * @var float
   */
  public $idf;
  /**
   * @var string
   */
  public $label;
  /**
   * @var QualitySalientTermsSalientTerm[]
   */
  public $originalTerm;
  protected $originalTermType = QualitySalientTermsSalientTerm::class;
  protected $originalTermDataType = 'array';
  /**
   * @var float
   */
  public $salience;
  /**
   * @var QualitySalientTermsSignalTermData[]
   */
  public $signalTerm;
  protected $signalTermType = QualitySalientTermsSignalTermData::class;
  protected $signalTermDataType = 'array';
  /**
   * @var float
   */
  public $virtualTf;
  /**
   * @var int
   */
  public $weight;

  /**
   * @param float
   */
  public function setIdf($idf)
  {
    $this->idf = $idf;
  }
  /**
   * @return float
   */
  public function getIdf()
  {
    return $this->idf;
  }
  /**
   * @param string
   */
  public function setLabel($label)
  {
    $this->label = $label;
  }
  /**
   * @return string
   */
  public function getLabel()
  {
    return $this->label;
  }
  /**
   * @param QualitySalientTermsSalientTerm[]
   */
  public function setOriginalTerm($originalTerm)
  {
    $this->originalTerm = $originalTerm;
  }
  /**
   * @return QualitySalientTermsSalientTerm[]
   */
  public function getOriginalTerm()
  {
    return $this->originalTerm;
  }
  /**
   * @param float
   */
  public function setSalience($salience)
  {
    $this->salience = $salience;
  }
  /**
   * @return float
   */
  public function getSalience()
  {
    return $this->salience;
  }
  /**
   * @param QualitySalientTermsSignalTermData[]
   */
  public function setSignalTerm($signalTerm)
  {
    $this->signalTerm = $signalTerm;
  }
  /**
   * @return QualitySalientTermsSignalTermData[]
   */
  public function getSignalTerm()
  {
    return $this->signalTerm;
  }
  /**
   * @param float
   */
  public function setVirtualTf($virtualTf)
  {
    $this->virtualTf = $virtualTf;
  }
  /**
   * @return float
   */
  public function getVirtualTf()
  {
    return $this->virtualTf;
  }
  /**
   * @param int
   */
  public function setWeight($weight)
  {
    $this->weight = $weight;
  }
  /**
   * @return int
   */
  public function getWeight()
  {
    return $this->weight;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(QualitySalientTermsSalientTerm::class, 'Google_Service_Contentwarehouse_QualitySalientTermsSalientTerm');
