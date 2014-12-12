<?php


namespace UBC\SISAPI\Provider;


use UBC\SISAPI\Authentication\AuthModule;
use UBC\SISAPI\HttpClient\HttpClient;
use UBC\SISAPI\Serializer\Serializer;
use UBC\SISAPI\Service\Config;

class SISDataProvider implements DataProvider
{
    protected $config;
    protected $client;
    protected $auth;
    protected $serializer;

    protected $response;
    protected $request;

    public function __construct(Config $config, HttpClient $client, AuthModule $auth, Serializer $serializer)
    {
        $this->config = $config;
        $this->client = $client;
        $this->auth = $auth;
        $this->serializer = $serializer;
    }

    public function getStudentCurrentSections($id)
    {
        $currentEligibility = $this->getStudentCurrentEligibility($id);
        if ($currentEligibility == null) {
            return array();
        }

        $sections = array();
        foreach ($currentEligibility->getSectionRefs() as $sectionRef) {
            $response = $this->get($sectionRef->getSectionLink());
            $sections[] = $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Section', 'xml');
        }

        return $sections;
    }

    public function getStudentCurrentEligibility($id)
    {
        $eligibilities = $this->getStudentEligibilities($id);
        $current = $eligibilities->getCurrentEligibility();
        if ($current == null) {
            return null;
        }
        $response = $this->get($current->getEligibilityLink());

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Eligibility', 'xml');
    }

    public function getStudentEligibilities($id)
    {
        $student = $this->getStudentById($id);
        $response = $this->get($student->getEligibilityLink());

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Eligibilities', 'xml');
    }

    public function getStudentById($id)
    {
        $response = $this->get('/student/' . $id);

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Student', 'xml');
    }

    public function getDepartmentCodes()
    {
        $response = $this->get('/departmentCode');

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\DepartmentCodes', 'xml');
    }

    public function getSubjectCodes()
    {
        $response = $this->get('/subjectCode');

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\SubjectCodes', 'xml');
    }

    protected function get($uri)
    {
        $url = $uri;
        if ((substr($uri, 0, 7) != 'http://') && (substr($uri, 0, 8) != 'https://')) {
            // the current link is an "relative" URL
            $url = $this->config->getBaseUrl() . $uri;
        }
        $headers = $this->auth->getHeader();

        $this->response = $this->client->get($url, ['headers' => $headers]);
        $body = $this->response->getBody();

        return $this->stripNamespace($body);
    }

    /**
     * As per https://github.com/schmittjoh/serializer/pull/301, JMS serializer doesn't support
     * namespace in XmlList and XmlMap, so we need to strip them out for now
     *
     * @param $str
     * @return string return
     */
    protected function stripNamespace($str)
    {
        return str_replace('atom:', '', $str);
    }

    /**
     * Proxy method to get the HTTP status code from client
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->client->getResponse()->getStatusCode();
    }

    public function getResponse()
    {
        return $this->response;
    }
}