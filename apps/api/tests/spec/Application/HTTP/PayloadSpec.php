<?php

namespace spec\Application\HTTP;

use PhpSpec\ObjectBehavior;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PayloadSpec extends ObjectBehavior
{
    public function it_fetches_parameters_from_request(): void
    {
        $this->beConstructedWith(Request::create(
            uri: '/test?key=value&many[]=a&many[]=b&other=c&multiple[]=andme',
            method: 'POST',
            parameters: [
                'unique' => 'value',
                'other' => 'd',
                'multiple' => ['foo', 'bar', 'baz'],
            ],
            files: [
                'document' => [
                    'tmp_name' => '/etc/hosts',
                    'name' => 'Host file',
                    'type' => 'text/plain',
                    'error' => 0,
                    'size' => 1234,
                ]
            ]
        ));

        $this->mandatory('unique')->shouldReturn('value');
        $this->mandatory('key')->shouldReturn('value');
        $this->mandatory('other')->shouldReturn('c');
        $this->shouldThrow(RuntimeException::class)->during('mandatory', ['inexistent']);
        $this->shouldThrow(RuntimeException::class)->during('mandatory', ['multiple']);

        $this->optional('unique')->shouldReturn('value');
        $this->optional('key')->shouldReturn('value');
        $this->optional('inexistent')->shouldReturn(null);
        $this->optional('inexistent', 'default')->shouldReturn('default');
        $this->shouldThrow(RuntimeException::class)->during('optional', ['multiple']);

        $this->mandatories('multiple')->shouldReturn(['foo', 'bar', 'baz', 'andme']);
        $this->mandatories('many')->shouldReturn(['a', 'b']);
        $this->shouldThrow(RuntimeException::class)->during('mandatories', ['inexistent']);
        $this->shouldThrow(RuntimeException::class)->during('mandatories', ['unique']);

        $this->optionals('multiple')->shouldReturn(['foo', 'bar', 'baz', 'andme']);
        $this->optionals('many')->shouldReturn(['a', 'b']);
        $this->optionals('inexistent')->shouldReturn([]);
        $this->shouldThrow(RuntimeException::class)->during('optionals', ['unique']);

        $this->file('document')->shouldHaveType(UploadedFile::class);
        $this->shouldThrow(RuntimeException::class)->during('file', ['inexistent']);
    }
}
