<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Voice\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $accountSid
 * @property string $sid
 * @property string $friendlyName
 * @property string $ipAddress
 * @property int $cidrPrefixLength
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string $url
 */
class IpRecordInstance extends InstanceResource {
    /**
     * Initialize the IpRecordInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The unique string that identifies the resource
     */
    public function __construct(Version $version, array $payload, string $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'sid' => Values::array_get($payload, 'sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'ipAddress' => Values::array_get($payload, 'ip_address'),
            'cidrPrefixLength' => Values::array_get($payload, 'cidr_prefix_length'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
        ];

        $this->solution = ['sid' => $sid ?: $this->properties['sid'], ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return IpRecordContext Context for this IpRecordInstance
     */
    protected function proxy(): IpRecordContext {
        if (!$this->context) {
            $this->context = new IpRecordContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }

    /**
     * Fetch the IpRecordInstance
     *
     * @return IpRecordInstance Fetched IpRecordInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): IpRecordInstance {
        return $this->proxy()->fetch();
    }

    /**
     * Update the IpRecordInstance
     *
     * @param array|Options $options Optional Arguments
     * @return IpRecordInstance Updated IpRecordInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): IpRecordInstance {
        return $this->proxy()->update($options);
    }

    /**
     * Delete the IpRecordInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool {
        return $this->proxy()->delete();
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name) {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Voice.V1.IpRecordInstance ' . \implode(' ', $context) . ']';
    }
}