<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Analytics Dashboard renderer
 *
 * @package    report_analytics_dashboard
 * @copyright  2020 Johanna Velander <johanna@adhibit.se>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
require_once (__DIR__ . "../../token_factory.php");
/**
 * Analytics Dashboard renderable class
 *
 * @package    report_analytics_dashboard
 * @copyright  2020 Johanna Velander <johanna@adhibit.se>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_analytics_dashboard_renderable implements renderable
{
    public $course;
    private $host = "https://moodle-charts-ng.web.app";
    public $libraries = "<script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyB7nILSkrrMM4SJn506S8dTiSpPXg7sRIk\"></script>
<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap\" rel=\"stylesheet\">
<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css\" />
<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/prism/1.16.0/themes/prism.css\" />
<base href=\"/\">";

    /**
     * Renderable constructor.
     *
     * @param stdClass|int $course (optional) course object or id.
     * @throws coding_exception if period is invalid.
     */
    public function __construct($course = null)
    {
        if (!empty($course)) {
            if (is_int($course)) {
                $course = get_course($course);
            }
            $this->course = $course;
        }
    }

    public function report_generate_analytics_dashboard()
    {
        global $USER;
        return $this->createNgEmbedTags($USER->id,
            '92ed261d8db589852de8',
            '359d5ee4682f20e936e9',
            'cae3149eebd3a5dc3703',
            '9a923f80951c4aba893e',
            '0f167fa5f10ea2d044f2');
    }

    private function createNgEmbedTags($userId, $cssVersion, $runtimeVersion, $ployfullsES5Version, $polyfillsVersion, $mainVersion)
    {
        $token = token_factory::generateToken($userId, $this->course);
        $ngTags = "<link rel=\"stylesheet\" href=\"$this->host/styles.$cssVersion.css\"
        ><app-root token=\"$token\">
        <script src=\"$this->host/runtime.$runtimeVersion.js\" defer></script>
        <script src=\"$this->host/polyfills-es5.$ployfullsES5Version.js\" nomodule defer></script>
        <script src=\"$this->host/polyfills.$polyfillsVersion.js\" defer></script>
        <script src=\"$this->host/main.$mainVersion.js\" defer></script>";

        return $this->libraries . $ngTags;
    }
}
