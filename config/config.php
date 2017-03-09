<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2016 Robert Sardinia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

$config = array();

$config['config'] = array(
    'corpID' => 0, // EVE Online corp ID (Leave as 0 if not using)
    'corpGroupID' => 0, // The group ID you want assigned to people in the correct corp (Leave as 0 if not using)
    'allianceID' => 0, // EVE Online alliance ID (Leave as 0 if not using)
    'allianceGroupID' => 0, // The group ID you want assigned to people in the correct alliance (Leave as 0 if not using)
    'registeredGroupID' => 14, // The group ID for default registered users (typically 14)
);

$config['database'] = array(
    'host' => 'localhost', //DB Host
    'user' => '', //Username
    'pass' => '', //Password
    'database' => '' //phpBB Database Name
);