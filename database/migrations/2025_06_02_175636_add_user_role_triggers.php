<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRoleTriggers extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER after_user_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                DECLARE role_name VARCHAR(255);
                SELECT name INTO role_name FROM roles WHERE id = NEW.role_id;

                IF role_name = "student" THEN
                    INSERT INTO students (user_id, career, created_at, updated_at)
                    VALUES (NEW.id, "Sin especificar", NOW(), NOW());
                ELSEIF role_name = "tutor" THEN
                    INSERT INTO tutors (user_id, specialty, created_at, updated_at)
                    VALUES (NEW.id, "Sin especificar", NOW(), NOW());
                END IF;
            END;
        ');

        DB::unprepared('
            CREATE TRIGGER after_user_update
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                DECLARE old_role_name VARCHAR(255);
                DECLARE new_role_name VARCHAR(255);

                SELECT name INTO old_role_name FROM roles WHERE id = OLD.role_id;
                SELECT name INTO new_role_name FROM roles WHERE id = NEW.role_id;

                IF old_role_name != new_role_name THEN
                    IF old_role_name = "student" THEN
                        DELETE FROM students WHERE user_id = OLD.id;
                    ELSEIF old_role_name = "tutor" THEN
                        DELETE FROM tutors WHERE user_id = OLD.id;
                    END IF;

                    IF new_role_name = "student" THEN
                        INSERT INTO students (user_id, career, created_at, updated_at)
                        VALUES (NEW.id, "Sin especificar", NOW(), NOW());
                    ELSEIF new_role_name = "tutor" THEN
                        INSERT INTO tutors (user_id, specialty, created_at, updated_at)
                        VALUES (NEW.id, "Sin especificar", NOW(), NOW());
                    END IF;
                END IF;
            END;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_insert;');
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_update;');
    }
}
