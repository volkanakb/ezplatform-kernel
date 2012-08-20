<?php
/**
 * File containing the UrlAliasRouter class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\MVC\Routing;

use eZ\Publish\API\Repository\Repository,
    eZ\Publish\API\Repository\Values\Content\URLAlias,
    eZ\Publish\API\Repository\Exceptions\NotFoundException,
    eZ\Publish\API\Repository\Values\Content\Location,
    eZ\Publish\MVC\View\Manager as ViewManager,
    Symfony\Component\Routing\RouterInterface,
    Symfony\Component\Routing\Matcher\RequestMatcherInterface,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Routing\RequestContext,
    Symfony\Component\HttpKernel\Log\LoggerInterface,
    Symfony\Component\Routing\RouteCollection,
    Symfony\Component\Routing\Exception\RouteNotFoundException,
    Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UrlAliasRouter implements RouterInterface, RequestMatcherInterface
{
    const URL_ALIAS_ROUTE_NAME = 'ez_urlalias';

    /**
     * @var \Symfony\Component\Routing\RequestContext
     */
    protected $requestContext;

    /**
     * @var \eZ\Publish\API\Repository\URLAliasService
     */
    protected $urlAliasService;

    /**
     * @var \Symfony\Component\HttpKernel\Log\LoggerInterface
     */
    protected $logger;

    public function __construct( Repository $repository, RequestContext $requestContext, LoggerInterface $logger = null )
    {
        $this->urlAliasService = $repository->getURLAliasService();
        $this->requestContext = isset( $requestContext ) ? $requestContext : new RequestContext();
        $this->logger = $logger;
    }

    /**
     * Tries to match a request with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param Request $request The request to match
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If no matching resource could be found
     * @throws MethodNotAllowedException If a matching resource was found but the request method is not allowed
     */
    public function matchRequest( Request $request )
    {
        try
        {
            $urlAlias = $this->urlAliasService->lookup(
                $request->attributes->get(
                    'semanticPathinfo',
                    $request->getPathInfo()
                ),
                // TODO : Don't hardcode language. Build the Repository with configured prioritized languages instead.
                'eng-GB'
            );

            $params = array(
                '_route' => self::URL_ALIAS_ROUTE_NAME
            );
            switch ( $urlAlias->type )
            {
                case UrlAlias::LOCATION:
                    $params += array(
                        '_controller'   => 'ezpublish.controller.content.view:viewLocation',
                        'locationId'    => $urlAlias->destination,
                        'viewType'      => ViewManager::VIEW_TYPE_FULL
                    );

                    if ( isset( $this->logger ) )
                        $this->logger->info( "UrlAlias matched location #$urlAlias->destination. Forwarding to ViewController" );

                    break;

                case UrlAlias::RESOURCE:
                case UrlAlias::VIRTUAL:
                    $request->attributes->set( 'semanticPathinfo', "/$urlAlias->destination" );
                    // In URLAlias terms, "forward" means "redirect".
                    if ( $urlAlias->forward )
                        $request->attributes->set( 'needsRedirect', true );
                    else
                        $request->attributes->set( 'needsForward', true );
                    break;
            }

            return $params;
        }
        catch ( NotFoundException $e )
        {
            throw new ResourceNotFoundException( $e->getMessage(), $e->getCode(), $e );
        }

        throw new ResourceNotFoundException( "Could not match UrlAlias" );
    }

    /**
     * Gets the RouteCollection instance associated with this Router.
     *
     * @return RouteCollection A RouteCollection instance
     */
    public function getRouteCollection()
    {
        return new RouteCollection();
    }

    /**
     * Generates a URL for a location, from the given parameters.
     * If applicable, the "location" key in $parameters must be set to a valid eZ\Publish\API\Repository\Values\Content\Location object.
     *
     * If the generator is not able to generate the url, it must throw the RouteNotFoundException
     * as documented below.
     *
     * @param string  $name       The name of the route
     * @param mixed   $parameters An array of parameters
     * @param Boolean $absolute   Whether to generate an absolute URL
     *
     * @throws \LogicException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @return string The generated URL
     *
     * @api
     */
    public function generate( $name, $parameters = array(), $absolute = false )
    {
        if ( $name === self::URL_ALIAS_ROUTE_NAME )
        {
            if ( !isset( $parameters['location'] ) || !$parameters['location'] instanceof Location )
            {
                throw new \LogicException(
                    "When generating an UrlAlias route, 'location' parameter must be a valid eZ\\Publish\\API\\Repository\\Values\\Content\\Location."
                );
            }

            $urlAliases = $this->urlAliasService->listLocationAliases(
                $parameters['location'],
                false,
                // TODO : Don't hardcode language. Build the Repository with configured prioritized languages instead.
                'eng-GB'
            );

            $url = $this->requestContext->getBaseUrl() . '/' . $urlAliases[0]->path;
            if ( $absolute )
            {
                $scheme = $this->requestContext->getScheme();
                $port = '';
                if ( $scheme === 'http' && $this->requestContext->getHttpPort() != 80 )
                {
                    $port = ':' . $this->requestContext->getHttpPort();
                }
                else if ( $scheme === 'https' && $this->requestContext->getHttpsPort() != 443 )
                {
                    $port = ':' . $this->requestContext->getHttpsPort();
                }

                $url = $scheme . '://' . $this->requestContext->getHost() . $port . $url;
            }

            return $url;
        }

        throw new RouteNotFoundException( 'Could not match route' );
    }

    public function setContext( RequestContext $context )
    {
        $this->requestContext = $context;
    }

    public function getContext()
    {
        return $this->requestContext;
    }

    /**
     * Not supported. Please use matchRequest() instead.
     *
     * @param $pathinfo
     * @return void
     * @throws \RuntimeException
     */
    public function match( $pathinfo )
    {
        throw new \RuntimeException( "The UrlAliasRouter doesn't support the match() method. Please use matchRequest() instead." );
    }
}
