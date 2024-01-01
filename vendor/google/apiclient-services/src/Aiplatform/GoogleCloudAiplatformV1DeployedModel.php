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

namespace Google\Service\Aiplatform;

class GoogleCloudAiplatformV1DeployedModel extends \Google\Model
{
  /**
   * @var GoogleCloudAiplatformV1AutomaticResources
   */
  public $automaticResources;
  protected $automaticResourcesType = GoogleCloudAiplatformV1AutomaticResources::class;
  protected $automaticResourcesDataType = '';
  /**
   * @var string
   */
  public $createTime;
  /**
   * @var GoogleCloudAiplatformV1DedicatedResources
   */
  public $dedicatedResources;
  protected $dedicatedResourcesType = GoogleCloudAiplatformV1DedicatedResources::class;
  protected $dedicatedResourcesDataType = '';
  /**
   * @var bool
   */
  public $disableContainerLogging;
  /**
   * @var string
   */
  public $displayName;
  /**
   * @var bool
   */
  public $enableAccessLogging;
  /**
   * @var GoogleCloudAiplatformV1ExplanationSpec
   */
  public $explanationSpec;
  protected $explanationSpecType = GoogleCloudAiplatformV1ExplanationSpec::class;
  protected $explanationSpecDataType = '';
  /**
   * @var string
   */
  public $id;
  /**
   * @var string
   */
  public $model;
  /**
   * @var string
   */
  public $modelVersionId;
  /**
   * @var GoogleCloudAiplatformV1PrivateEndpoints
   */
  public $privateEndpoints;
  protected $privateEndpointsType = GoogleCloudAiplatformV1PrivateEndpoints::class;
  protected $privateEndpointsDataType = '';
  /**
   * @var string
   */
  public $serviceAccount;

  /**
   * @param GoogleCloudAiplatformV1AutomaticResources
   */
  public function setAutomaticResources(GoogleCloudAiplatformV1AutomaticResources $automaticResources)
  {
    $this->automaticResources = $automaticResources;
  }
  /**
   * @return GoogleCloudAiplatformV1AutomaticResources
   */
  public function getAutomaticResources()
  {
    return $this->automaticResources;
  }
  /**
   * @param string
   */
  public function setCreateTime($createTime)
  {
    $this->createTime = $createTime;
  }
  /**
   * @return string
   */
  public function getCreateTime()
  {
    return $this->createTime;
  }
  /**
   * @param GoogleCloudAiplatformV1DedicatedResources
   */
  public function setDedicatedResources(GoogleCloudAiplatformV1DedicatedResources $dedicatedResources)
  {
    $this->dedicatedResources = $dedicatedResources;
  }
  /**
   * @return GoogleCloudAiplatformV1DedicatedResources
   */
  public function getDedicatedResources()
  {
    return $this->dedicatedResources;
  }
  /**
   * @param bool
   */
  public function setDisableContainerLogging($disableContainerLogging)
  {
    $this->disableContainerLogging = $disableContainerLogging;
  }
  /**
   * @return bool
   */
  public function getDisableContainerLogging()
  {
    return $this->disableContainerLogging;
  }
  /**
   * @param string
   */
  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }
  /**
   * @return string
   */
  public function getDisplayName()
  {
    return $this->displayName;
  }
  /**
   * @param bool
   */
  public function setEnableAccessLogging($enableAccessLogging)
  {
    $this->enableAccessLogging = $enableAccessLogging;
  }
  /**
   * @return bool
   */
  public function getEnableAccessLogging()
  {
    return $this->enableAccessLogging;
  }
  /**
   * @param GoogleCloudAiplatformV1ExplanationSpec
   */
  public function setExplanationSpec(GoogleCloudAiplatformV1ExplanationSpec $explanationSpec)
  {
    $this->explanationSpec = $explanationSpec;
  }
  /**
   * @return GoogleCloudAiplatformV1ExplanationSpec
   */
  public function getExplanationSpec()
  {
    return $this->explanationSpec;
  }
  /**
   * @param string
   */
  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * @return string
   */
  public function getId()
  {
    return $this->id;
  }
  /**
   * @param string
   */
  public function setModel($model)
  {
    $this->model = $model;
  }
  /**
   * @return string
   */
  public function getModel()
  {
    return $this->model;
  }
  /**
   * @param string
   */
  public function setModelVersionId($modelVersionId)
  {
    $this->modelVersionId = $modelVersionId;
  }
  /**
   * @return string
   */
  public function getModelVersionId()
  {
    return $this->modelVersionId;
  }
  /**
   * @param GoogleCloudAiplatformV1PrivateEndpoints
   */
  public function setPrivateEndpoints(GoogleCloudAiplatformV1PrivateEndpoints $privateEndpoints)
  {
    $this->privateEndpoints = $privateEndpoints;
  }
  /**
   * @return GoogleCloudAiplatformV1PrivateEndpoints
   */
  public function getPrivateEndpoints()
  {
    return $this->privateEndpoints;
  }
  /**
   * @param string
   */
  public function setServiceAccount($serviceAccount)
  {
    $this->serviceAccount = $serviceAccount;
  }
  /**
   * @return string
   */
  public function getServiceAccount()
  {
    return $this->serviceAccount;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudAiplatformV1DeployedModel::class, 'Google_Service_Aiplatform_GoogleCloudAiplatformV1DeployedModel');
