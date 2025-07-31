# Linder - AI-Powered Dating Profile App

A viral Tinder-like application that generates dynamic pickup lines and profile descriptions using OpenAI's GPT models.

## Features

- **AI-Powered Pickup Lines**: Generate personalized pickup lines using OpenAI's GPT models
- **Dynamic Profile Descriptions**: Create engaging bio lines for dating profiles
- **MongoDB Integration**: Store profiles and user data in MongoDB
- **Responsive UI**: Built with daisyUI and Tailwind CSS
- **Real-time Interactions**: Livewire components for seamless user experience
- **Caching**: Smart caching system to optimize API usage and performance

## OpenAI Integration

This application uses OpenAI's GPT models to generate creative and personalized content:

### Setup

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Environment Configuration**
   Copy `.env.example` to `.env` and add your OpenAI credentials:
   ```env
   OPENAI_API_KEY=your_openai_api_key_here
   OPENAI_ORGANIZATION=your_org_id_here
   OPENAI_DEFAULT_MODEL=gpt-3.5-turbo
   OPENAI_MAX_TOKENS=150
   OPENAI_TEMPERATURE=0.9
   OPENAI_CACHE_TTL=3600
   ```

3. **Test OpenAI Integration**
   ```bash
   php artisan openai:test --name="Sarah" --age=25 --location="New York"
   ```

### API Usage

**Generate Pickup Line**
```bash
POST /api/generate-pickup-line
Content-Type: application/json

{
    "name": "Sarah",
    "age": 25,
    "location": "New York",
    "for_self": false
}
```

**Generate Self Description**
```bash
POST /api/generate-pickup-line
Content-Type: application/json

{
    "name": "John",
    "age": 28,
    "location": "San Francisco",
    "for_self": true
}
```

### Features

- **Smart Caching**: Reduces API costs by caching responses for 1 hour
- **Fallback System**: Uses predefined lines when OpenAI is unavailable
- **Configurable Models**: Switch between GPT-3.5-turbo, GPT-4, etc.
- **Temperature Control**: Adjust creativity levels for different content types
- **Error Handling**: Graceful degradation with logging

### Service Architecture

The OpenAI integration is built around the `OpenAIService` class which provides:

- `generatePickupLine($name, $age, $location)` - Creates personalized pickup lines
- `generateSelfDescriptionLine($age, $location)` - Generates profile bio lines
- Automatic caching and error handling
- Configurable prompts and parameters

## Technologies Used

- **Laravel 12** - PHP framework
- **MongoDB** - Database
- **OpenAI PHP SDK** - AI integration
- **Livewire** - Reactive components
- **daisyUI + Tailwind CSS** - UI framework
- **AWS S3** - File storage

## Installation

1. Clone the repository
2. Install dependencies: `composer install && npm install`
3. Set up environment variables in `.env`
4. Run migrations: `php artisan migrate`
5. Start the development server: `php artisan serve`

## Contributing

Thank you for considering contributing to Linder! Please ensure all AI-generated content follows ethical guidelines and maintains respectful, appropriate messaging.

## License

The Linder application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
