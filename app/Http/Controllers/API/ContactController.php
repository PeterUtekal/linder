<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function submit(Request $request, string $slug)
    {
        $profile = Profile::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_type' => 'required|in:instagram,selfie',
            'contact_value' => 'required_if:contact_type,instagram|max:255',
            'selfie' => 'required_if:contact_type,selfie|image|max:5120', // 5MB max
            'message' => 'nullable|string|max:500'
        ]);

        $contactData = [
            'profile_id' => $profile->id,
            'name' => $validated['name'],
            'contact_type' => $validated['contact_type'],
            'message' => $validated['message'] ?? null,
            'created_at' => now()
        ];

        // Handle Instagram contact
        if ($validated['contact_type'] === 'instagram') {
            $contactData['contact_value'] = $validated['contact_value'];
        }

        // Handle selfie upload
        if ($validated['contact_type'] === 'selfie' && $request->hasFile('selfie')) {
            $path = $request->file('selfie')->store('selfies', 'public');
            $contactData['selfie_url'] = Storage::url($path);
        }

        // Create contact record
        $contact = Contact::create($contactData);

        // Send notification to profile owner
        $this->notifyProfileOwner($profile, $contact);

        return response()->json([
            'success' => true,
            'message' => 'Contact information sent successfully!'
        ]);
    }

    private function notifyProfileOwner(Profile $profile, Contact $contact)
    {
        // Check notification preference
        if ($profile->contact_type === 'email' && $profile->contact_value) {
            $this->sendEmailNotification($profile, $contact);
        } elseif ($profile->contact_type === 'sms' && $profile->contact_value) {
            $this->sendSmsNotification($profile, $contact);
        }
    }

    private function sendEmailNotification(Profile $profile, Contact $contact)
    {
        // TODO: Implement email notification
        // You would use Laravel Mail here
        // Mail::to($profile->contact_value)->send(new NewContactNotification($contact));
    }

    private function sendSmsNotification(Profile $profile, Contact $contact)
    {
        // TODO: Implement SMS notification
        // You would use a service like Twilio here
        // Twilio::message($profile->contact_value, "New contact from {$contact->name}!");
    }
}