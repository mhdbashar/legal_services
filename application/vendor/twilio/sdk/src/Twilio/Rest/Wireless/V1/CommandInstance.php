<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Wireless\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $sid
 * @property string $accountSid
 * @property string $simSid
 * @property string $command
 * @property string $commandMode
 * @property string $transport
 * @property bool $deliveryReceiptRequested
 * @property string $status
 * @property string $direction
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string $url
 */
class CommandInstance extends InstanceResource {
    /**
     * Initialize the CommandInstance
     *
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The SID that identifies the resource to fetch
     * @return \Twilio\Rest\Wireless\V1\CommandInstance
     */
    public function __construct(Version $version, array $payload, $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = array(
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'simSid' => Values::array_get($payload, 'sim_sid'),
            'command' => Values::array_get($payload, 'command'),
            'commandMode' => Values::array_get($payload, 'command_mode'),
            'transport' => Values::array_get($payload, 'transport'),
            'deliveryReceiptRequested' => Values::array_get($payload, 'delivery_receipt_requested'),
            'status' => Values::array_get($payload, 'status'),
            'direction' => Values::array_get($payload, 'direction'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
        );

        $this->solution = array('sid' => $sid ?: $this->properties['sid'], );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return \Twilio\Rest\Wireless\V1\CommandContext Context for this
     *                                                 CommandInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new CommandContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }

    /**
     * Fetch a CommandInstance
     *
     * @return CommandInstance Fetched CommandInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Deletes the CommandInstance
     *
     * @return boolean True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name) {
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
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Wireless.V1.CommandInstance ' . \implode(' ', $context) . ']';
    }
}