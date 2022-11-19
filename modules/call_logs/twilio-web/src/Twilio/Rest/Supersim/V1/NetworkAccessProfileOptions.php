<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
abstract class NetworkAccessProfileOptions {
    /**
     * @param string $uniqueName An application-defined string that uniquely
     *                           identifies the resource
     * @param string[] $networks List of Network SIDs that this Network Access
     *                           Profile will allow connections to
     * @return CreateNetworkAccessProfileOptions Options builder
     */
    public static function create(string $uniqueName = Values::NONE, array $networks = Values::ARRAY_NONE): CreateNetworkAccessProfileOptions {
        return new CreateNetworkAccessProfileOptions($uniqueName, $networks);
    }

    /**
     * @param string $uniqueName The new unique name of the resource
     * @return UpdateNetworkAccessProfileOptions Options builder
     */
    public static function update(string $uniqueName = Values::NONE): UpdateNetworkAccessProfileOptions {
        return new UpdateNetworkAccessProfileOptions($uniqueName);
    }
}

class CreateNetworkAccessProfileOptions extends Options {
    /**
     * @param string $uniqueName An application-defined string that uniquely
     *                           identifies the resource
     * @param string[] $networks List of Network SIDs that this Network Access
     *                           Profile will allow connections to
     */
    public function __construct(string $uniqueName = Values::NONE, array $networks = Values::ARRAY_NONE) {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['networks'] = $networks;
    }

    /**
     * An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     *
     * @param string $uniqueName An application-defined string that uniquely
     *                           identifies the resource
     * @return $this Fluent Builder
     */
    public function setUniqueName(string $uniqueName): self {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    /**
     * List of Network SIDs that this Network Access Profile will allow connections to.
     *
     * @param string[] $networks List of Network SIDs that this Network Access
     *                           Profile will allow connections to
     * @return $this Fluent Builder
     */
    public function setNetworks(array $networks): self {
        $this->options['networks'] = $networks;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $options = \http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.CreateNetworkAccessProfileOptions ' . $options . ']';
    }
}

class UpdateNetworkAccessProfileOptions extends Options {
    /**
     * @param string $uniqueName The new unique name of the resource
     */
    public function __construct(string $uniqueName = Values::NONE) {
        $this->options['uniqueName'] = $uniqueName;
    }

    /**
     * The new unique name of the Network Access Profile.
     *
     * @param string $uniqueName The new unique name of the resource
     * @return $this Fluent Builder
     */
    public function setUniqueName(string $uniqueName): self {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $options = \http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Supersim.V1.UpdateNetworkAccessProfileOptions ' . $options . ']';
    }
}