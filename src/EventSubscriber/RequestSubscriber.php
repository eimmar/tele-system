<?php
namespace App\EventSubscriber;
use App\Service\VisitTracker;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var array
     */
    private $redirectRoutes;

    /**
     * @var VisitTracker
     */
    private $visitTracker;

    /**
     * RegistrationListener constructor.
     * @param UrlGeneratorInterface $router
     * @param VisitTracker $visitTracker
     */
    public function __construct(UrlGeneratorInterface $router, VisitTracker $visitTracker) {
        $this->router = $router;
        $this->visitTracker = $visitTracker;
        $this->redirectRoutes = [
            'fos_user_registration_register',
            'fos_user_security_login',
        ];
    }
    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse'
        ];
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $this->visitTracker->trackVisit($request);

        if (in_array($request->get('_route'), $this->redirectRoutes, true)
            && $request->getSession()->get('_security_main')
        ) {
            $route = $this->router->generate('homepage');
            $event->setResponse(new RedirectResponse($route));
        }
        $event->stopPropagation();
    }
}
