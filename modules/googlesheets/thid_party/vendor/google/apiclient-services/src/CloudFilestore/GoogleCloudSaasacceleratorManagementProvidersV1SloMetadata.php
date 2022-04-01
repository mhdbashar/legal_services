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

namespace Google\Service\CloudFilestore;

class GoogleCloudSaasacceleratorManagementProvidersV1SloMetadata extends \Google\Collection
{
  protected $collection_key = 'nodes';
  protected $eligibilityType = GoogleCloudSaasacceleratorManagementProvidersV1SloEligibility::class;
  protected $eligibilityDataType = '';
  protected $exclusionsType = GoogleCloudSaasacceleratorManagementProvidersV1SloExclusion::class;
  protected $exclusionsDataType = 'array';
  protected $nodesType = GoogleCloudSaasacceleratorManagementProvidersV1NodeSloMetadata::class;
  protected $nodesDataType = 'array';
  protected $perSliEligibilityType = GoogleCloudSaasacceleratorManagementProvidersV1PerSliSloEligibility::class;
  protected $perSliEligibilityDataType = '';
  public $tier;

  /**
   * @param GoogleCloudSaasacceleratorManagementProvidersV1SloEligibility
   */
  public function setEligibility(GoogleCloudSaasacceleratorManagementProvidersV1SloEligibility $eligibility)
  {
    $this->eligibility = $eligibility;
  }
  /**
   * @return GoogleCloudSaasacceleratorManagementProvidersV1SloEligibility
   */
  public function getEligibility()
  {
    return $this->eligibility;
  }
  /**
   * @param GoogleCloudSaasacceleratorManagementProvidersV1SloExclusion[]
   */
  public function setExclusions($exclusions)
  {
    $this->exclusions = $exclusions;
  }
  /**
   * @return GoogleCloudSaasacceleratorManagementProvidersV1SloExclusion[]
   */
  public function getExclusions()
  {
    return $this->exclusions;
  }
  /**
   * @param GoogleCloudSaasacceleratorManagementProvidersV1NodeSloMetadata[]
   */
  public function setNodes($nodes)
  {
    $this->nodes = $nodes;
  }
  /**
   * @return GoogleCloudSaasacceleratorManagementProvidersV1NodeSloMetadata[]
   */
  public function getNodes()
  {
    return $this->nodes;
  }
  /**
   * @param GoogleCloudSaasacceleratorManagementProvidersV1PerSliSloEligibility
   */
  public function setPerSliEligibility(GoogleCloudSaasacceleratorManagementProvidersV1PerSliSloEligibility $perSliEligibility)
  {
    $this->perSliEligibility = $perSliEligibility;
  }
  /**
   * @return GoogleCloudSaasacceleratorManagementProvidersV1PerSliSloEligibility
   */
  public function getPerSliEligibility()
  {
    return $this->perSliEligibility;
  }
  public function setTier($tier)
  {
    $this->tier = $tier;
  }
  public function getTier()
  {
    return $this->tier;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudSaasacceleratorManagementProvidersV1SloMetadata::class, 'Google_Service_CloudFilestore_GoogleCloudSaasacceleratorManagementProvidersV1SloMetadata');
