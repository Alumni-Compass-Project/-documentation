<?php

$factoriesDir = __DIR__ . '/Backend-Laravel/database/factories';
$seedersDir = __DIR__ . '/Backend-Laravel/database/seeders';

if (!is_dir($factoriesDir)) {
    mkdir($factoriesDir, 0755, true);
}
if (!is_dir($seedersDir)) {
    mkdir($seedersDir, 0755, true);
}

// UserFactory
file_put_contents("$factoriesDir/UserFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserFactory extends Factory {
    public function definition(): array {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_active' => true,
        ];
    }
}
PHP);

// RoleFactory
file_put_contents("$factoriesDir/RoleFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class RoleFactory extends Factory {
    public function definition(): array {
        return [
            'name' => $this->faker->unique()->word(),
            'slug' => $this->faker->unique()->slug(),
        ];
    }
}
PHP);

// ProfileFactory
file_put_contents("$factoriesDir/ProfileFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProfileFactory extends Factory {
    public function definition(): array {
        $cities = ['Sana\'a', 'Taiz', 'Aden', 'Ibb', 'Dhamar', 'Hadramout', 'Al Hudaydah', 'Mukalla'];
        $universities = ['Taiz University', 'Sana\'a University', 'Aden University', 'Hadhramout University', 'Thamar University'];
        return [
            'headline' => $this->faker->jobTitle(),
            'bio' => $this->faker->paragraph(),
            'university' => $this->faker->randomElement($universities),
            'graduation_year' => $this->faker->numberBetween(2022, 2026),
            'current_company' => $this->faker->company(),
            'current_role' => $this->faker->jobTitle(),
            'country' => 'Yemen',
            'city' => $this->faker->randomElement($cities),
            'timezone' => 'Asia/Aden',
            'avatar_url' => 'https://ui-avatars.com/api/?name='.urlencode($this->faker->name()),
            'linkedin_url' => 'https://linkedin.com/in/' . $this->faker->slug(),
            'github_url' => 'https://github.com/' . $this->faker->slug(),
            'website_url' => $this->faker->url(),
            'is_public' => true,
            'completion_score' => $this->faker->numberBetween(50, 100),
        ];
    }
}
PHP);

// MentorProfileFactory
file_put_contents("$factoriesDir/MentorProfileFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MentorProfileFactory extends Factory {
    public function definition(): array {
        return [
            'years_experience' => $this->faker->numberBetween(2, 20),
            'hourly_rate_cents' => $this->faker->numberBetween(1000, 15000),
            'currency' => 'USD',
            'max_mentees' => $this->faker->numberBetween(1, 10),
            'accepting_new_mentees' => true,
            'approval_status' => 'approved',
            'approved_at' => now(),
        ];
    }
}
PHP);

// MentorAvailabilityFactory
file_put_contents("$factoriesDir/MentorAvailabilityFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MentorAvailabilityFactory extends Factory {
    public function definition(): array {
        return [
            'day_of_week' => $this->faker->numberBetween(1, 7),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'timezone' => 'Asia/Aden',
            'is_active' => true,
        ];
    }
}
PHP);

// SkillFactory
file_put_contents("$factoriesDir/SkillFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class SkillFactory extends Factory {
    public function definition(): array {
        $name = $this->faker->unique()->word();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
        ];
    }
}
PHP);

// BookingFactory
file_put_contents("$factoriesDir/BookingFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class BookingFactory extends Factory {
    public function definition(): array {
        $starts = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $ends = (clone $starts)->modify('+1 hour');
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled', 'rescheduled', 'rejected'];
        $status = $this->faker->randomElement($statuses);
        return [
            'starts_at' => $starts,
            'ends_at' => $ends,
            'status' => $status,
            'meeting_provider' => 'google_meet',
            'meeting_link' => 'https://meet.google.com/abc-defg-hij',
            'agenda' => $this->faker->paragraph(),
            'mentor_notes' => $this->faker->paragraph(),
            'price_cents' => $this->faker->numberBetween(2000, 10000),
            'currency' => 'USD',
            'confirmed_at' => in_array($status, ['confirmed', 'completed']) ? $starts : null,
            'completed_at' => $status === 'completed' ? $ends : null,
            'cancelled_at' => in_array($status, ['cancelled', 'rejected']) ? $starts : null,
        ];
    }
}
PHP);

// BookingEventFactory
file_put_contents("$factoriesDir/BookingEventFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class BookingEventFactory extends Factory {
    public function definition(): array {
        return [
            'event_type' => $this->faker->randomElement(['created', 'confirmed', 'cancelled', 'completed']),
            'payload' => json_encode(['note' => $this->faker->sentence()]),
        ];
    }
}
PHP);

// ConversationFactory
file_put_contents("$factoriesDir/ConversationFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class ConversationFactory extends Factory {
    public function definition(): array {
        return [
            'type' => 'direct',
            'last_message_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
PHP);

// ConversationParticipantFactory
file_put_contents("$factoriesDir/ConversationParticipantFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class ConversationParticipantFactory extends Factory {
    public function definition(): array {
        return [
            'last_read_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
PHP);

// MessageFactory
file_put_contents("$factoriesDir/MessageFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MessageFactory extends Factory {
    public function definition(): array {
        return [
            'body' => $this->faker->paragraph(),
            'message_type' => 'text',
            'read_at' => $this->faker->boolean(70) ? now() : null,
        ];
    }
}
PHP);

// UserNotificationFactory
file_put_contents("$factoriesDir/UserNotificationFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class UserNotificationFactory extends Factory {
    public function definition(): array {
        $isRead = $this->faker->boolean();
        return [
            'type' => $this->faker->randomElement(['booking_confirmed', 'booking_cancelled', 'reminder', 'system', 'ai_recommendation']),
            'channel' => 'in_app',
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'is_read' => $isRead,
            'read_at' => $isRead ? now() : null,
            'sent_at' => now(),
        ];
    }
}
PHP);

// AdminAuditLogFactory
file_put_contents("$factoriesDir/AdminAuditLogFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class AdminAuditLogFactory extends Factory {
    public function definition(): array {
        return [
            'action' => $this->faker->randomElement(['user_login', 'user_updated', 'mentor_approved', 'settings_changed']),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'metadata' => json_encode(['details' => 'test']),
        ];
    }
}
PHP);

// AnalyticsSnapshotFactory
file_put_contents("$factoriesDir/AnalyticsSnapshotFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class AnalyticsSnapshotFactory extends Factory {
    public function definition(): array {
        return [
            'metric_key' => $this->faker->randomElement(['daily_active_users', 'total_bookings', 'total_revenue', 'new_mentors']),
            'metric_value' => $this->faker->randomFloat(2, 0, 1000),
            'recorded_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
PHP);

// AiRequestFactory
file_put_contents("$factoriesDir/AiRequestFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class AiRequestFactory extends Factory {
    public function definition(): array {
        $op = $this->faker->randomElement(['recommend', 'cv/analyze']);
        return [
            'provider' => 'fastapi',
            'operation' => $op,
            'status' => $this->faker->randomElement(['completed', 'completed', 'completed', 'failed']),
            'latency_ms' => $this->faker->numberBetween(100, 3000),
            'processed_at' => now(),
        ];
    }
}
PHP);

// SystemSettingFactory
file_put_contents("$factoriesDir/SystemSettingFactory.php", <<< 'PHP'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class SystemSettingFactory extends Factory {
    public function definition(): array {
        return [
            'key' => $this->faker->unique()->word(),
            'value' => json_encode(['setting' => true]),
        ];
    }
}
PHP);

// Finally DatabaseSeeder
file_put_contents("$seedersDir/DatabaseSeeder.php", <<< 'PHP'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Skill;
use App\Models\Profile;
use App\Models\MentorProfile;
use App\Models\MentorAvailability;
use App\Models\Booking;
use App\Models\BookingEvent;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\UserNotification;
use App\Models\AdminAuditLog;
use App\Models\AnalyticsSnapshot;
use App\Models\AiRequest;
use App\Models\SystemSetting;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'slug' => 'admin']);
        $mentorRole = Role::firstOrCreate(['name' => 'Mentor', 'slug' => 'mentor']);
        $studentRole = Role::firstOrCreate(['name' => 'Student', 'slug' => 'student']);

        // Admin
        $admin = User::firstOrCreate(['email' => 'admin@alumnicompass.com'], [
            'first_name' => 'System',
            'last_name' => 'Admin',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        if(!$admin->roles()->where('id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id);
        }

        // Skills
        $skillNames = ['Laravel', 'PHP', 'React', 'Vue', 'Angular', 'Node.js', 'Python', 'Java', 'C#', 'Flutter', 'Docker', 'Kubernetes', 'Git', 'Linux', 'MySQL', 'PostgreSQL', 'MongoDB', 'TensorFlow', 'PyTorch', 'Machine Learning', 'Artificial Intelligence', 'Cyber Security', 'Networking', 'AWS', 'Azure', 'Google Cloud', 'REST API', 'GraphQL'];
        $skills = collect();
        foreach($skillNames as $name) {
            $skills->push(Skill::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_active' => true]));
        }

        // Generate 25 Mentors
        $mentors = collect();
        $demoMentor = User::firstOrCreate(['email' => 'mentor1@alumnicompass.com'], [
            'first_name' => 'Demo',
            'last_name' => 'Mentor',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        if(!$demoMentor->roles()->where('id', $mentorRole->id)->exists()) {
            $demoMentor->roles()->attach($mentorRole->id);
        }
        $mentors->push($demoMentor);
        Profile::factory()->create(['user_id' => $demoMentor->id]);
        MentorProfile::factory()->create(['user_id' => $demoMentor->id]);

        for($i = 0; $i < 24; $i++) {
            $m = User::factory()->create();
            $m->roles()->attach($mentorRole->id);
            Profile::factory()->create(['user_id' => $m->id]);
            MentorProfile::factory()->create(['user_id' => $m->id]);
            for($d = 1; $d <= 5; $d++) {
                MentorAvailability::factory()->create(['mentor_user_id' => $m->id, 'day_of_week' => $d]);
            }
            $m->skills()->attach($skills->random(rand(3, 8))->pluck('id')->toArray(), ['proficiency' => rand(3, 5)]);
            $mentors->push($m);
        }
        
        // Generate 80 Students
        $students = collect();
        $demoStudent = User::firstOrCreate(['email' => 'student1@alumnicompass.com'], [
            'first_name' => 'Demo',
            'last_name' => 'Student',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        if(!$demoStudent->roles()->where('id', $studentRole->id)->exists()) {
            $demoStudent->roles()->attach($studentRole->id);
        }
        $students->push($demoStudent);
        Profile::factory()->create(['user_id' => $demoStudent->id]);

        for($i = 0; $i < 79; $i++) {
            $s = User::factory()->create();
            $s->roles()->attach($studentRole->id);
            Profile::factory()->create(['user_id' => $s->id]);
            $students->push($s);
        }

        // Generate Bookings
        for($i = 0; $i < 120; $i++) {
            $mentor = $mentors->random();
            $student = $students->random();
            $booking = Booking::factory()->create(['mentor_user_id' => $mentor->id, 'mentee_user_id' => $student->id]);
            BookingEvent::factory()->create(['booking_id' => $booking->id, 'actor_user_id' => $student->id]);
        }

        // Generate Conversations & Messages
        for($i = 0; $i < 40; $i++) {
            $mentor = $mentors->random();
            $student = $students->random();
            $conv = Conversation::factory()->create();
            ConversationParticipant::factory()->create(['conversation_id' => $conv->id, 'user_id' => $mentor->id]);
            ConversationParticipant::factory()->create(['conversation_id' => $conv->id, 'user_id' => $student->id]);
            
            for($j = 0; $j < rand(5, 15); $j++) {
                Message::factory()->create([
                    'conversation_id' => $conv->id,
                    'sender_user_id' => $j % 2 == 0 ? $mentor->id : $student->id,
                ]);
            }
        }

        // Notifications
        foreach($students->random(40) as $user) {
            UserNotification::factory()->count(rand(2, 5))->create(['user_id' => $user->id]);
        }
        foreach($mentors->random(15) as $user) {
            UserNotification::factory()->count(rand(2, 5))->create(['user_id' => $user->id]);
        }

        // Audit Logs
        for($i = 0; $i < 30; $i++) {
            AdminAuditLog::factory()->create(['actor_user_id' => $admin->id]);
        }

        // Analytics
        for($i = 0; $i < 60; $i++) {
            AnalyticsSnapshot::factory()->create();
        }

        // AI Requests
        foreach($students->random(30) as $user) {
            AiRequest::factory()->create(['user_id' => $user->id]);
        }
    }
}
PHP);
