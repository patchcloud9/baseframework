<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-6 is-offset-3">
                <h1 class="title"><?= htmlspecialchars($title) ?></h1>
                
                <div class="box">
                    <form method="POST" action="/contact">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" placeholder="Your name" required>
                            </div>
                        </div>
                        
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" placeholder="your@email.com" required>
                            </div>
                        </div>
                        
                        <div class="field">
                            <label class="label">Message</label>
                            <div class="control">
                                <textarea class="textarea" name="message" placeholder="Your message" required></textarea>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="notification is-info is-light">
                    <strong>Note:</strong> This form POSTs to <code>/contact</code>, which is handled by 
                    <code>HomeController::contactSubmit()</code>. Try submitting it!
                </div>
            </div>
        </div>
    </div>
</section>
