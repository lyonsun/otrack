<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= '{field} 为必填项.';
$lang['form_validation_isset']			= '必须赋予 {field} 一个值.';
$lang['form_validation_valid_email']		= '{field} 必须是一个有效的电子邮件地址.';
$lang['form_validation_valid_emails']		= '{field} 必须都是一个有效的电子邮件地址.';
$lang['form_validation_valid_url']		= '{field} 必须是一个有效的网络URL地址.';
$lang['form_validation_valid_ip']		= '{field} 必须是一个有效的IP地址.';
$lang['form_validation_min_length']		= '{field} 必须包含至少 {param} 长度的文字.';
$lang['form_validation_max_length']		= '{field} 包含不超出 {param} 长度的文字.';
$lang['form_validation_exact_length']		= '{field} 必须包含刚好 {param} 长度的文字.';
$lang['form_validation_alpha']			= '{field} 应当只包含拉丁字母.';
$lang['form_validation_alpha_numeric']		= '{field} 应当只包含拉丁字母或者数字.';
$lang['form_validation_alpha_numeric_spaces']	= '{field} 应当只包含拉丁字母，数字或者空格.';
$lang['form_validation_alpha_dash']		= '{field} 应当只包含拉丁字母，数字，空格，下划线或者横杠.';
$lang['form_validation_numeric']		= '{field} 应当只包含数字.';
$lang['form_validation_is_numeric']		= '{field} 应当只包含数字字符.';
$lang['form_validation_integer']		= '{field} 必须是一个整数.';
$lang['form_validation_regex_match']		= '{field} 不符合正确格式.';
$lang['form_validation_matches']		= '{field} 与 {param} 不匹配.';
$lang['form_validation_differs']		= '{field} 应当跟 {param} 不相同.';
$lang['form_validation_is_unique'] 		= '{field} 必须是唯一的.';
$lang['form_validation_is_natural']		= '{field} 必须是一个自然数.';
$lang['form_validation_is_natural_no_zero']	= '{field} 必须是一个非零的自然数.';
$lang['form_validation_decimal']		= '{field} 必须是一个小数.';
$lang['form_validation_less_than']		= '{field} 必须是一个比 {param} 小的数字.';
$lang['form_validation_less_than_equal_to']	= '{field} 必须是一个比 {param} 小或者跟它相等的数字.';
$lang['form_validation_greater_than']		= '{field} 必须是一个比 {param} 大的数字.';
$lang['form_validation_greater_than_equal_to']	= '{field} 必须是一个比 {param} 大或者跟它相等的数字.';
$lang['form_validation_error_message_not_set']	= '无法获取 {field} 项对应的错误信息.';
$lang['form_validation_in_list']		= '{field} 必须是 {param} 的一个子项.';
