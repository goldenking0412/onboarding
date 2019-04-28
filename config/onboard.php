<?php
/**
 * Created by PhpStorm.
 * User: ktnan
 * Date: 7/23/2018
 * Time: 12:23 PM
 */

return [


    'services' => [
        [
            'name'          => 'Stripe',
            'register-url'  => "https://dashboard.stripe.com/register",
            'icon'          => "cc-stripe",
            'link'          => "/knowledgebase/category/2",
            'description'   => "We use Stripe to process payments on our Reservation page, which measures the purchase intent and quality of the leads we collect. We need this to complete Landing Page Development."
        ],
        [
            'name'          => 'Facebook',
            'register-url'  => "https://business.facebook.com",
            'icon'          => "facebook-official",
            'link'          => "/knowledgebase/category/4",
            'description'   => "Adding us to your Facebook page allows us to run ads from your page, create lookalikes of your page followers, and avoid spending money targeting people who are already engaged with your brand. We need this to start running ads on Facebook."
        ],
        [
            'name'          => 'Mailchimp',
            'register-url'  => "https://login.mailchimp.com/signup/",
            'icon'          => "envelope",
            'link'          => "/knowledgebase/category/1",
            'description'   => "MailChimp is the email marketing platform we use to manage our lead generation and automate email sequences. We need access to program our email sequences and start automation. The domain needs to be verified, and the account needs to be on a monthly payment plan for the best open rates."
        ],
    ]
];