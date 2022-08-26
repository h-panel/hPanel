<?php

namespace Pterodactyl\Tests\Traits\Http;

use Mockery as m;
use Illuminate\Http\Request;
use Pterodactyl\Models\User;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\ParameterBag;

trait RequestMockHelpers
{
    /**
     * @var string
     */
    private $requestMockClass = Request::class;

    /**
     * @var \Illuminate\Http\Request|\Mockery\Mock
     */
    protected $request;

    /**
     * Set the class to mock for requests.
     */
    public function setRequestMockClass(string $class)
    {
        $this->requestMockClass = $class;

        $this->buildRequestMock();
    }

    /**
     * Configure the user model that the request mock should return with.
     */
    public function setRequestUserModel(User $user = null)
    {
        $this->request->shouldReceive('user')->andReturn($user);
    }

    /**
     * Generates a new request user model and also returns the generated model.
     */
    public function generateRequestUserModel(array $args = []): User
    {
        $user = User::factory()->make($args);
        $this->setRequestUserModel($user);

        return $user;
    }

    /**
     * Set a request attribute on the mock object.
     *
     * @param mixed $value
     */
    public function setRequestAttribute(string $attribute, $value)
    {
        $this->request->attributes->set($attribute, $value);
    }

    /**
     * Set the request route name.
     */
    public function setRequestRouteName(string $name)
    {
        $this->request->shouldReceive('route->getName')->andReturn($name);
    }

    /**
     * Set the active request object to be an instance of a mocked request.
     */
    protected function buildRequestMock()
    {
        $this->request = m::mock($this->requestMockClass);
        if (!$this->request instanceof Request) {
            throw new InvalidArgumentException('Request mock class must be an instance of ' . Request::class . ' when mocked.');
        }

        $this->request->attributes = new ParameterBag();
    }

    /**
     * Sets the mocked request user. If a user model is not provided, a factory model
     * will be created and returned.
     *
     * @deprecated
     */
    protected function setRequestUser(User $user = null): User
    {
        $user = $user instanceof User ? $user : User::factory()->make();
        $this->request->shouldReceive('user')->withNoArgs()->andReturn($user);

        return $user;
    }
}
