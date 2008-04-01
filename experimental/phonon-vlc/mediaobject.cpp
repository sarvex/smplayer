/*
 * VLC backend for the Phonon library
 * Copyright (C) 2007-2008  Tanguy Krotoff <tkrotoff@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

#include "mediaobject.h"

#include "vlcmediaobject.h"

#include <QtCore/QUrl>
#include <QtCore/QMetaType>

namespace Phonon
{
namespace VLC
{

MediaObject::MediaObject(QObject * parent)
	: QObject(parent) {

	_currentState = Phonon::LoadingState;

	_vlcMediaObject = new VLCMediaObject(this);

	qRegisterMetaType<QMultiMap<QString, QString> >("QMultiMap<QString, QString>");

	connect(_vlcMediaObject, SIGNAL(tick(qint64)),
		SIGNAL(tick(qint64)), Qt::QueuedConnection);
	connect(_vlcMediaObject, SIGNAL(stateChanged(Phonon::State)),
		SLOT(stateChangedInternal(Phonon::State)), Qt::QueuedConnection);
	connect(_vlcMediaObject, SIGNAL(totalTimeChanged(qint64)),
		SIGNAL(totalTimeChanged(qint64)), Qt::QueuedConnection);
	connect(_vlcMediaObject, SIGNAL(metaDataChanged(const QMultiMap<QString, QString> &)),
		SLOT(metaDataChangedInternal(const QMultiMap<QString, QString> &)), Qt::QueuedConnection);
	connect(_vlcMediaObject, SIGNAL(finished()),
		SIGNAL(finished()), Qt::QueuedConnection);
}

MediaObject::~MediaObject() {
	delete _vlcMediaObject;
}

void MediaObject::play() {
	switch (_mediaSource.type()) {

	case MediaSource::Invalid:
		break;

	case MediaSource::LocalFile:
		playInternal(_mediaSource.fileName());
		break;

	case MediaSource::Url:
		playInternal(_mediaSource.url().toString());
		break;

	case MediaSource::Disc: {
		switch (_mediaSource.discType()) {
		case Phonon::NoDisc:
			//kFatal(610) << "I should never get to see a MediaSource that is a disc but doesn't specify which one";
			return;
		case Phonon::Cd:
			playInternal(_mediaSource.deviceName());
			break;
		case Phonon::Dvd:
			playInternal(_mediaSource.deviceName());
			break;
		case Phonon::Vcd:
			playInternal(_mediaSource.deviceName());
			break;
		default:
			qCritical() << __FUNCTION__ << "error: unsupported MediaSource::Disc:" << _mediaSource.discType();
		}
		break;
	}

	case MediaSource::Stream:
		break;

	default:
		qCritical() << __FUNCTION__ << "error: unsupported MediaSource:" << _mediaSource.type();
		break;

	}
}

void MediaObject::loadMediaInternal(const QString & filename) {
	//Default MediaObject state is Phonon::LoadingState
	_currentState = Phonon::LoadingState;

	//Loads the libvlc_media
	_vlcMediaObject->loadMedia(filename);
}

void MediaObject::playInternal(const QString & filename) {
	if (_currentState == Phonon::PausedState) {
		resume();
	}

	else {
		//Play the libvlc_media
		_vlcMediaObject->play();
	}
}

void MediaObject::resume() {
	pause();
}

void MediaObject::pause() {
	_vlcMediaObject->pause();
}

void MediaObject::stop() {
	_vlcMediaObject->stop();
}

void MediaObject::seek(qint64 milliseconds) {
	_vlcMediaObject->seek(milliseconds);
}

qint32 MediaObject::tickInterval() const {
	return 1000;
}

void MediaObject::setTickInterval(qint32 interval) {
}

bool MediaObject::hasVideo() const {
	return _vlcMediaObject->hasVideo();
}

bool MediaObject::isSeekable() const {
	return _vlcMediaObject->isSeekable();
}

qint64 MediaObject::currentTime() const {
	qint64 time = -1;
	Phonon::State st = state();

	switch(st) {
	case Phonon::PausedState:
		time = _vlcMediaObject->currentTime();
		break;
	case Phonon::BufferingState:
		time = _vlcMediaObject->currentTime();
		break;
	case Phonon::PlayingState:
		time = _vlcMediaObject->currentTime();
		break;
	case Phonon::StoppedState:
		time = 0;
		break;
	case Phonon::LoadingState:
		time = 0;
		break;
	case Phonon::ErrorState:
		time = -1;
		break;
	default:
		qCritical() << __FUNCTION__ << "error: unsupported Phonon::State:" << st;
	}

	return time;
}

Phonon::State MediaObject::state() const {
	return _vlcMediaObject->state();
}

QString MediaObject::errorString() const {
	return _vlcMediaObject->errorString();
}

Phonon::ErrorType MediaObject::errorType() const {
	return Phonon::NormalError;
}

qint64 MediaObject::totalTime() const {
	return _vlcMediaObject->totalTime();
}

MediaSource MediaObject::source() const {
	return _mediaSource;
}

void MediaObject::setSource(const MediaSource & source) {
	_mediaSource = source;

	switch (source.type()) {
	case MediaSource::Invalid:
		break;
	case MediaSource::LocalFile:
		loadMediaInternal(_mediaSource.fileName());
		break;
	case MediaSource::Url:
		loadMediaInternal(_mediaSource.url().toString());
		break;
	case MediaSource::Disc: {
		switch (source.discType()) {
		case Phonon::NoDisc:
			qCritical() << __FUNCTION__ << "error: the MediaSource::Disc doesn't specify which one (Phonon::NoDisc)";
			return;
		case Phonon::Cd:
			loadMediaInternal(_mediaSource.deviceName());
			break;
		case Phonon::Dvd:
			loadMediaInternal(_mediaSource.deviceName());
			break;
		case Phonon::Vcd:
			loadMediaInternal(_mediaSource.deviceName());
			break;
		default:
			qCritical() << __FUNCTION__ << "error: unsupported MediaSource::Disc:" << source.discType();
			break;
		}
		}
		break;
	case MediaSource::Stream:
		break;
	default:
		qCritical() << __FUNCTION__ << "error: unsupported MediaSource:" << source.type();
		break;
	}
}

void MediaObject::setNextSource(const MediaSource & source) {
	setSource(source);
}

qint32 MediaObject::prefinishMark() const {
	return 0;
}

void MediaObject::setPrefinishMark(qint32) {
}

qint32 MediaObject::transitionTime() const {
	return 0;
}

void MediaObject::setTransitionTime(qint32) {
}

bool MediaObject::hasInterface(Interface iface) const {
	return true;
}

QVariant MediaObject::interfaceCall(Interface iface, int command, const QList<QVariant> & arguments) {
	return new QVariant();
}

void MediaObject::stateChangedInternal(Phonon::State newState) {
	if (newState == _currentState) {
		//No state changed
		return;
	}

	//State changed
	Phonon::State previousState = _currentState;
	_currentState = newState;
	emit stateChanged(_currentState, previousState);
}

void MediaObject::metaDataChangedInternal(const QMultiMap<QString, QString> & metaData) {
	emit metaDataChanged(metaData);

	stateChangedInternal(Phonon::StoppedState);
}

}}	//Namespace Phonon::VLC
