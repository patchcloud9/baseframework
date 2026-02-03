<?php

namespace App\Controllers;

/**
 * Home Controller
 * 
 * Handles the main pages of the site.
 */
class HomeController extends Controller
{
    /**
     * Home page
     * Route: GET /
     */
    public function index(): void
    {
        $data = [
            'title' => 'Welcome Home',
            'message' => 'This is the home page rendered through the routing system!',
            'time' => date('Y-m-d H:i:s'),
        ];
        
        $this->view('home/index', $data);
    }
    
    /**
     * About page
     * Route: GET /about
     */
    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About Us',
        ]);
    }
    
    /**
     * Contact page (GET - show form)
     * Route: GET /contact
     */
    public function contact(): void
    {
        $this->view('home/contact', [
            'title' => 'Contact Us',
        ]);
    }
    
    /**
     * Contact form submission (POST)
     * Route: POST /contact
     */
    public function contactSubmit(): void
    {
        $this->verifyCsrf();
        
        // Get form data
        $name = $this->input('name');
        $email = $this->input('email');
        $message = $this->input('message');
        
        // In a real app, you'd validate and save/send this
        // For now, just show what was received
        
        $this->flash('success', "Thanks {$name}! We received your message.");
        $this->redirect('/contact');
    }
    
    /**
     * Debug page - shows how routing works
     * Route: GET /debug
     */
    public function debug(): void
    {
        // Gather debug info
        $debugInfo = [
            'Request' => [
                'Method' => $_SERVER['REQUEST_METHOD'],
                'URI' => $_SERVER['REQUEST_URI'],
                'Query String' => $_SERVER['QUERY_STRING'] ?? '(none)',
            ],
            'Server' => [
                'PHP Version' => phpversion(),
                'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'Document Root' => $_SERVER['DOCUMENT_ROOT'],
            ],
            'Paths' => [
                'BASE_PATH' => BASE_PATH,
                'Current File' => __FILE__,
            ],
            'Session' => $_SESSION,
            'GET Parameters' => $_GET ?: '(none)',
            'POST Parameters' => $_POST ?: '(none)',
        ];
        
        $this->view('home/debug', [
            'title' => 'Debug Info',
            'debugInfo' => $debugInfo,
        ]);
    }
}
