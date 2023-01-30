<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use Craft;
use craft\base\Component;
use craft\commerce\elements\Order;
use craft\elements\Address;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\IpAddress;

class CustomerService extends Component
{

    /**
     * @param Order $order
     * @return CustomerDetails
     */
    public function createCustomerDetails(Order $order): CustomerDetails
    {
        $customer = new CustomerDetails();

        return $customer
            ->addAddress($this->createAddress($order->getBillingAddress()))
            ->addEmailAddress(new Customer\EmailAddress($order->getEmail()))
            ->addFirstName($order->getBillingAddress()->firstName)
            ->addLastName($order->getBillingAddress()->lastName)
            ->addPhoneNumber(new Customer\PhoneNumber($order->getBillingAddress()->getFieldValue('phoneNumber')))
            ->addIpAddress(new IpAddress($this->getCurrentSessionIpAddress()))
            ->addUserAgent($this->getUserAgent())
            ->addLocale($this->getCurrentLocale());
    }

    /**
     * @param Order $order
     * @return CustomerDetails
     */
    public function createDeliveryDetails(Order $order): CustomerDetails
    {
        $customer = new CustomerDetails();
        $shippingAddress = $order->getShippingAddress();

        return $customer
            ->addAddress($this->createAddress($shippingAddress))
            ->addEmailAddress(new Customer\EmailAddress($order->getEmail()))
            ->addFirstName($shippingAddress->firstName)
            ->addLastName($shippingAddress->lastName)
            ->addPhoneNumber(new Customer\PhoneNumber($shippingAddress->getFieldValue('phoneNumber')))
            ->addIpAddress(new IpAddress($this->getCurrentSessionIpAddress()))
            ->addUserAgent($this->getUserAgent())
            ->addLocale($this->getCurrentLocale());
    }

    /**
     * @param Address $craftAddress
     * @return Customer\Address
     */
    private function createAddress(Address $craftAddress): Customer\Address
    {
        $address = new Customer\Address();

        $addressParser = new Customer\AddressParser();
        $parsedAddress = $addressParser->parse($craftAddress->getAddressLine1(), $craftAddress->getAddressLine2());

        return $address
            ->addStreetName($parsedAddress[0])
            ->addHouseNumber($parsedAddress[1])
            ->addState($craftAddress->getAdministrativeArea() ?? "")
            ->addCity($craftAddress->getLocality())
            ->addCountry(new Customer\Country($craftAddress->getCountryCode()))
            ->addZipCode($craftAddress->getPostalCode());
    }

    /**
     * @return string
     */
    private function getCurrentSessionIpAddress(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return string
     */
    private function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return string
     */
    private function getCurrentLocale(): string
    {
        $locale = Craft::$app->getLocale()->id;

        if (strpos($locale, '-') !== false) {
            return str_replace('-', '_', $locale);
        }

        return $locale;
    }
}
